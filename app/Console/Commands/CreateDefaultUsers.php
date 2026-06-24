<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUsers extends Command
{
    protected $signature = 'app:create-default-users';

    protected $description = 'Create default admin ';

    public function handle()
    {
        User::updateOrCreate(
            ['email' => 'saviourpaul24@gmail.com'],
            [
                'first_name' => 'System',
                'last_name' =>'Administrator',
                'username' =>'Admin',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
            ]
        );

       

        $this->info('Default users created successfully.');

        return Command::SUCCESS;
    }
}