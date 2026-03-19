<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ResumeQaAgentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ResumeQaAgentController extends Controller
{
    public function __construct(private readonly ResumeQaAgentService $agent) {}

    /**
     * Ask a question about the authenticated user's primary resume.
     *
     * @group         AI Agent
     *
     * @bodyParam question string required The question to ask about the resume. Example: What are the main skills on this resume?
     * @bodyParam language string optional Response language: `en` for English, `fi` for Finnish. Omit to auto-detect from the question. Example: fi
     *
     * @response 200 {
     *   "answer": "The main skills listed on this resume are..."
     * }
     * @response 404 {"message": "No primary resume found for this user."}
     * @response 422 {"message": "The question field is required."}
     * @response 502 {"message": "AI agent error: ..."}
     */
    /**
     * Get a list of suggested questions for the AI agent.
     *
     * @group AI Agent
     */
    public function suggestions(): JsonResponse
    {
        return response()->json([
            'suggestions' => [
                ['en' => 'Who is Jussi Alanen?',                          'fi' => 'Kuka on Jussi Alanen?'],
                ['en' => 'What are the main skills on this resume?',       'fi' => 'Mitkä ovat tärkeimmät taidot?'],
                ['en' => 'What work experience does Jussi have?',          'fi' => 'Millainen työkokemus Jussilla on?'],
                ['en' => 'What is the educational background?',            'fi' => 'Mikä on koulutustausta?'],
                ['en' => 'What projects has Jussi worked on?',             'fi' => 'Missä projekteissa Jussi on ollut mukana?'],
                ['en' => 'What certifications does Jussi have?',           'fi' => 'Mitä sertifikaatteja Jussilla on?'],
                ['en' => 'Where can I find the LinkedIn profile?',         'fi' => 'Mistä löydän LinkedIn-profiilin?'],
                ['en' => 'What languages does Jussi speak?',               'fi' => 'Mitä kieliä Jussi osaa?'],
                ['en' => 'Tell about your resume/CV?',                    'fi' => 'Kerro ansioluettelostasi?'],
            ],
        ]);
    }

    public function ask(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:1000'],
            'language' => ['nullable', 'string', 'in:en,fi'],
        ]);

        try {
            $answer = $this->agent->ask(
                $validated['question'],
                userId: 1,
                language: $validated['language'] ?? null,
            );
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'No primary resume found for this user.'], 404);
        } catch (RuntimeException $e) {
            return response()->json(['message' => "AI agent error: {$e->getMessage()}"], 502);
        }

        return response()->json(['answer' => $answer]);
    }
}
