<?php

namespace Database\Seeders;

use App\Models\User;
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
        $userPermissions = [
            'users.index',   // View
            'users.create',  // Create new
            'users.store',   // Store new
            'users.show',    // View individual
            'users.edit',    // Edit
            'users.update',  // Update
            'users.destroy', // Delete
        ];

        $rolePermissions = [
            'roles.index',   // View
            'roles.create',  // Create new
            'roles.store',   // Store new
            'roles.show',    // View individual
            'roles.edit',    // Edit
            'roles.update',  // Update
            'roles.destroy', // Delete
        ];

        $permissionPermissions = [
            'permissions.index',   // View
            'permissions.create',  // Create new
            'permissions.store',   // Store new
            'permissions.show',    // View individual
            'permissions.edit',    // Edit
            'permissions.update',  // Update
            'permissions.destroy', // Delete
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

        $postPermissions = [
            'posts.index',   // View all posts
            'posts.create',  // Create new post
            'posts.store',   // Store new post
            'posts.show',    // View individual post
            'posts.edit',    // Edit post
            'posts.update',  // Update post
            'posts.destroy', // Delete post
        ];

        foreach ($userPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'User'
            ]);
        }
        foreach ($rolePermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Role'
            ]);
        }
        foreach ($permissionPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Permission'
            ]);
        }
        foreach ($categoryPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Category'
            ]);
        }
        foreach ($postPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'module' => 'Post'
            ]);
        }
        // End Permissions

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // Assign Permissions to Roles
        $adminRole->syncPermissions(Permission::all());
        $editorRole->syncPermissions([
            'users.index',
            'users.create',
            'users.store',
            'users.edit',
            'users.update',
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.edit',
            'categories.update',
            'posts.index',
            'posts.create',
            'posts.store',
            'posts.edit',
            'posts.update',
        ]);

        // Assign role to a user (for testing)
        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
