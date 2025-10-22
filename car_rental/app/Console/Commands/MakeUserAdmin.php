<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email? : The email of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin by their email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $email = $this->ask('Enter the user email');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found!");
            
            // Show available users
            if ($this->confirm('Do you want to see all users?', true)) {
                $this->info("\nAvailable users:");
                $users = User::all(['id', 'name', 'email', 'role']);
                $this->table(
                    ['ID', 'Name', 'Email', 'Current Role'],
                    $users->map(function($u) {
                        return [$u->id, $u->name, $u->email, $u->role];
                    })
                );
            }
            
            return 1;
        }

        if ($user->role === 'admin') {
            $this->info("User '{$user->name}' is already an admin!");
            return 0;
        }

        $user->role = 'admin';
        $user->save();

        $this->info("✓ User '{$user->name}' ({$user->email}) has been made an admin!");
        $this->info("They can now access the admin panel at: /admin");
        
        return 0;
    }
}
