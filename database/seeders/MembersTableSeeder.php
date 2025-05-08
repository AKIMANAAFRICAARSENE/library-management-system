<?php

namespace Database\Seeders;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '1234567890',
                'address' => '123 Main St, City',
                'membership_date' => Carbon::now(),
                'role' => 'student',
                'status' => 'active',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '0987654321',
                'address' => '456 Park Ave, Town',
                'membership_date' => Carbon::now(),
                'role' => 'teacher',
                'status' => 'active',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'phone' => '5556667777',
                'address' => '789 Pine St, Village',
                'membership_date' => Carbon::now(),
                'role' => 'student',
                'status' => 'active',
            ],
        ];

        foreach ($members as $memberData) {
            Member::firstOrCreate(
                ['email' => $memberData['email']],
                $memberData
            );
        }
    }
}
