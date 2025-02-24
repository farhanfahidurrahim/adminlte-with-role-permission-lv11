<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $postPermissions = [
            'posts.index',   // View all posts
            'posts.create',  // Create new post
            'posts.store',   // Store new post
            'posts.show',    // View individual post
            'posts.edit',    // Edit post
            'posts.update',  // Update post
            'posts.destroy', // Delete post
        ];

        $categoryPermissions = [
            'categories.index',   // View categories
            'categories.create',  // Create new category
            'categories.store',   // Store new category
            'categories.show',    // View individual category
            'categories.edit',    // Edit category
            'categories.update',  // Update category
            'categories.destroy', // Delete category
        ];

        foreach (array_merge($postPermissions, $categoryPermissions) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // Assign Permissions to Roles
        $adminRole->syncPermissions(Permission::all());
        $editorRole->syncPermissions([
            'posts.index', 'categories.index',
        ]);

        // Assign role to a user (for testing)
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
