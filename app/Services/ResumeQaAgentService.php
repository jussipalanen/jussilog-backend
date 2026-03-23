<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Resume;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

/**
 * ResumeQaAgentService class provides a method to ask questions about a user's primary resume using Google Vertex AI's generative models.
 */
class ResumeQaAgentService
{
    /**
     * The HTTP client.
     */
    private Client $http;

    /**
     * The Google project id.
     */
    private string $projectId;

    /**
     * The region for the AI agent.
     */
    private string $location;

    /**
     * The model code name.
     */
    private string $model;

    public function __construct(private readonly ResumeService $resumeService)
    {
        $this->http      = new Client(['timeout' => 30]);
        $this->projectId = (string) config('services.vertex_ai.project_id');
        $this->location  = (string) config('services.vertex_ai.location');
        $this->model     = (string) config('services.vertex_ai.model');
    }

    /**
     * Ask a question about the primary resume of the given user.
     *
     * @param  string|null  $language  'en', 'fi', or null to auto-detect from the question
     *
     * @throws RuntimeException
     */
    public function ask(string $question, int $userId = 1, ?string $language = null): string
    {
        $resume  = $this->resumeService->getPrimaryResume($userId);
        $context = $this->formatResume($resume);
        $token   = $this->accessToken();
        $prompt  = $this->buildPrompt($question, $context, $language);

        $endpoint = sprintf(
            'https://%s-aiplatform.googleapis.com/v1/projects/%s/locations/%s/publishers/google/models/%s:generateContent',
            $this->location,
            $this->projectId,
            $this->location,
            $this->model,
        );

        try {
            $response = $this->http->post($endpoint, [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'role'  => 'user',
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.2,
                        'maxOutputTokens' => 8192,
                    ],
                ],
            ]);
        } catch (GuzzleException $e) {
            throw new RuntimeException("Vertex AI request failed: {$e->getMessage()}", 0, $e);
        }

        $body = json_decode((string) $response->getBody(), true);

        return $body['candidates'][0]['content']['parts'][0]['text']
            ?? throw new RuntimeException('Unexpected Vertex AI response format.');
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    private function buildPrompt(string $question, string $context, ?string $language): string
    {
        $languageInstruction = match ($language) {
            'fi'    => 'Vastaa aina suomeksi.',
            'en'    => 'Always respond in English.',
            default => 'Detect the language of the question and respond in the same language (Finnish or English).',
        };

        return "You are a resume assistant. {$languageInstruction}\n\nUse the following resume data to answer the question. If the question is about who the person is (e.g. their name, identity, or a casual greeting like their first name), give a friendly introduction based on the resume. Always include LinkedIn, Portfolio, and GitHub URLs when relevant or when asked. When the answer includes a photo, render it as an HTML image tag like <img src=\"URL_HERE\" alt=\"Name\">.\n\nResume:\n{$context}\n\nQuestion: {$question}";
    }

    private function formatResume(Resume $resume): string
    {
        $lines = [];

        $lines[] = "Name: {$resume->full_name}";
        $lines[] = "Email: {$resume->email}";
        $lines[] = "Phone: {$resume->phone}";
        $lines[] = "Location: {$resume->location}";

        if ($resume->linkedin_url) {
            $lines[] = "LinkedIn: {$resume->linkedin_url}";
        }

        if ($resume->portfolio_url) {
            $lines[] = "Portfolio: {$resume->portfolio_url}";
        }

        if ($resume->github_url) {
            $lines[] = "GitHub: {$resume->github_url}";
        }

        if ($resume->photo) {
            $lines[] = 'Photo URL: '.$this->storageUrl($resume->photo);
        }

        if ($resume->summary) {
            $lines[] = "\nSummary:\n{$resume->summary}";
        }

        if ($resume->workExperiences->isNotEmpty()) {
            $lines[] = "\nWork Experience:";
            foreach ($resume->workExperiences as $exp) {
                $end     = $exp->is_current ? 'Present' : ($exp->end_date ?? '');
                $lines[] = "  - {$exp->job_title} at {$exp->company_name} ({$exp->start_date} – {$end})";
                if ($exp->description) {
                    $lines[] = "    {$exp->description}";
                }
            }
        }

        if ($resume->educations->isNotEmpty()) {
            $lines[] = "\nEducation:";
            foreach ($resume->educations as $edu) {
                $lines[] = "  - {$edu->degree} in {$edu->field_of_study}, {$edu->institution_name} ({$edu->graduation_year})";
            }
        }

        if ($resume->skills->isNotEmpty()) {
            $lines[] = "\nSkills:";
            foreach ($resume->skills as $skill) {
                $lines[] = "  - {$skill->name} ({$skill->category})";
            }
        }

        if ($resume->certifications->isNotEmpty()) {
            $lines[] = "\nCertifications:";
            foreach ($resume->certifications as $cert) {
                $lines[] = "  - {$cert->name} ({$cert->issue_date})";
            }
        }

        if ($resume->languages->isNotEmpty()) {
            $lines[] = "\nLanguages:";
            foreach ($resume->languages as $lang) {
                $lines[] = "  - {$lang->language} ({$lang->proficiency})";
            }
        }

        if ($resume->projects->isNotEmpty()) {
            $lines[] = "\nProjects:";
            foreach ($resume->projects as $project) {
                $lines[] = "  - {$project->name}";
                if (! empty($project->description)) {
                    $lines[] = "    {$project->description}";
                }
            }
        }

        return implode("\n", $lines);
    }

    /**
     * Get a Google OAuth2 access token.
     *
     * Priority:
     *   1. VERTEX_AI_ACCESS_TOKEN  — static token (quick local test)
     *   2. VERTEX_AI_KEY_FILE      — service account JSON key (local dev / CI)
     *   3. GCP metadata server     — Cloud Run (no config needed)
     */
    private function accessToken(): string
    {
        $staticToken = (string) config('services.vertex_ai.access_token');

        if ($staticToken !== '') {
            return $staticToken;
        }

        $keyFile = (string) config('services.vertex_ai.key_file');

        if ($keyFile !== '') {
            return $this->tokenFromServiceAccountKey($keyFile);
        }

        return $this->tokenFromMetadataServer();
    }

    /**
     * Generate an access token by signing a JWT with the service account private key
     * and exchanging it at the Google OAuth2 token endpoint.
     */
    private function tokenFromServiceAccountKey(string $keyFilePath): string
    {
        if (! str_starts_with($keyFilePath, '/')) {
            $keyFilePath = base_path($keyFilePath);
        }

        if (! file_exists($keyFilePath)) {
            throw new RuntimeException("Service account key file not found: {$keyFilePath}");
        }

        $key = json_decode((string) file_get_contents($keyFilePath), true);

        if (empty($key['private_key']) || empty($key['client_email'])) {
            throw new RuntimeException('Invalid service account key file: missing private_key or client_email.');
        }

        $now     = time();
        $header  = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $payload = $this->base64UrlEncode(json_encode([
            'iss'   => $key['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => $now,
            'exp'   => $now + 3600,
        ]));

        $signingInput = "{$header}.{$payload}";
        $privateKey   = openssl_pkey_get_private($key['private_key']);

        if ($privateKey === false) {
            throw new RuntimeException('Failed to load private key from service account key file.');
        }

        openssl_sign($signingInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $jwt = "{$signingInput}.".$this->base64UrlEncode($signature);

        try {
            $response = $this->http->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion'  => $jwt,
                ],
            ]);
        } catch (GuzzleException $e) {
            throw new RuntimeException("Failed to exchange service account JWT for access token: {$e->getMessage()}", 0, $e);
        }

        $body = json_decode((string) $response->getBody(), true);

        return $body['access_token']
            ?? throw new RuntimeException('Missing access_token in OAuth2 token response.');
    }

    private function tokenFromMetadataServer(): string
    {
        try {
            $response = $this->http->get(
                'http://metadata.google.internal/computeMetadata/v1/instance/service-accounts/default/token',
                ['headers' => ['Metadata-Flavor' => 'Google']]
            );

            $body = json_decode((string) $response->getBody(), true);

            return $body['access_token']
                ?? throw new RuntimeException('Missing access_token in metadata server response.');
        } catch (GuzzleException $e) {
            throw new RuntimeException(
                'Could not retrieve GCP access token. Set VERTEX_AI_KEY_FILE or VERTEX_AI_ACCESS_TOKEN for local development.',
                0,
                $e
            );
        }
    }

    private function storageUrl(string $path): string
    {
        $endpoint = rtrim((string) config('filesystems.disks.gcs.endpoint', 'https://storage.googleapis.com'), '/');
        $bucket   = (string) config('filesystems.disks.gcs.bucket');

        return "{$endpoint}/{$bucket}/{$path}";
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
