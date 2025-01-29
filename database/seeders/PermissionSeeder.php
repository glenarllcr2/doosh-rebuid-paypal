<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'emoji'],
            ['name' => 'message_64'],
            ['name' => 'message_1024'],
            ['name' => 'chat'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
