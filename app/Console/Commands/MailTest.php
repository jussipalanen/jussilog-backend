<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\TestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {--to=} {--subject=} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email using the configured mailer.';

    public function handle(): int
    {
        $to = $this->option('to');

        if (empty($to)) {
            if (!$this->input->isInteractive()) {
                $this->error('The --to option is required.');

                return self::FAILURE;
            }

            $to = $this->ask('Recipient email');
        }

        if (empty($to)) {
            $this->error('Recipient email is required.');

            return self::FAILURE;
        }

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email format is invalid.');

            return self::FAILURE;
        }

        $subject = $this->option('subject') ?? 'Test email';
        $messageBody = $this->option('message') ?? 'This is a test email sent from Artisan.';

        Mail::to($to)->send(new TestMail($subject, $messageBody));

        $this->info("Test email sent to {$to}.");

        return self::SUCCESS;
    }
}
