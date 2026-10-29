<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * The administrator account is created here on purpose: a trusted seeder is
     * the only place allowed to assign the admin role, so a visitor can never
     * register into an administrator account.
     */
    public function run(): void
    {
        $this->createUser(
            name: 'Administrator',
            email: 'admin@example.com',
            role: User::ROLE_ADMIN,
        );

        $this->createUser(
            name: 'Regular User',
            email: 'user@example.com',
            role: User::ROLE_USER,
        );

        $this->call(ProductSeeder::class);
    }

    private function createUser(string $name, string $email, string $role): User
    {
        $user = User::query()->firstOrNew(['email' => $email]);

        $user->name = $name;
        $user->password = 'password';
        // "role" is not mass assignable, so it is forced explicitly.
        $user->role = $role;
        $user->email_verified_at ??= now();
        $user->save();

        return $user;
    }
}
