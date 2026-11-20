<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('guestbook:create-admin {email} {--name=Administrator}')]
#[Description('Create or promote an administrator account for the guestbook')]
class CreateGuestbookAdmin extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = Str::lower(trim((string) $this->argument('email')));
        $name = trim((string) $this->option('name'));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || $name === '') {
            $this->components->error('Provide a valid email address and a non-empty name.');

            return self::FAILURE;
        }

        $password = $this->secret('Admin password (minimum 12 characters)');
        $confirmation = $this->secret('Confirm admin password');

        if (! is_string($password) || strlen($password) < 12) {
            $this->components->error('The admin password must contain at least 12 characters.');

            return self::FAILURE;
        }

        if (! is_string($confirmation) || ! hash_equals($password, $confirmation)) {
            $this->components->error('The passwords do not match.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => $password, 'is_admin' => true],
        );

        $this->components->info("Administrator account {$email} is ready.");

        return self::SUCCESS;
    }
}
