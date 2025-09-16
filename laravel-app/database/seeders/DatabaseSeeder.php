<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles (idempotent)
        $userRole = Role::firstOrCreate(['name' => RolesEnum::User->value, 'guard_name' => 'web']);
        $commenterRole = Role::firstOrCreate(['name' => RolesEnum::Commenter->value, 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => RolesEnum::Admin->value, 'guard_name' => 'web']);

        // Permissions (idempotent)
        $manageFeaturesPermission = Permission::firstOrCreate(['name' => PermissionsEnum::ManageFeatures->value, 'guard_name' => 'web']);
        $manageCommentsPermission = Permission::firstOrCreate(['name' => PermissionsEnum::ManageComments->value, 'guard_name' => 'web']);
        $manageUsersPermission    = Permission::firstOrCreate(['name' => PermissionsEnum::ManageUsers->value, 'guard_name' => 'web']);
        $upvoteDownvotePermission = Permission::firstOrCreate(['name' => PermissionsEnum::UpvoteDownvote->value, 'guard_name' => 'web']);

        // Attach permissions to roles
        $userRole->syncPermissions([$upvoteDownvotePermission]);
        $commenterRole->syncPermissions([$upvoteDownvotePermission, $manageCommentsPermission]);
        $adminRole->syncPermissions([
            $upvoteDownvotePermission,
            $manageUsersPermission,
            $manageCommentsPermission,
            $manageFeaturesPermission,
        ]);

        // Users (idempotent via updateOrCreate)
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User User']
        )->assignRole(RolesEnum::User);

        User::updateOrCreate(
            ['email' => 'commenter@example.com'],
            ['name' => 'Commenter User']
        )->assignRole(RolesEnum::Commenter);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User']
        )->assignRole(RolesEnum::Admin);

        // Features (factory, only run if empty to avoid duplicates)
        if (Feature::count() === 0) {
            Feature::factory(100)->create();
        }
    }
}
