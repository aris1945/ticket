<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class ShieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Permissions ---
        // Anda bisa menambahkan permission kustom di sini sesuai kebutuhan aplikasi Anda.
        // Contoh:
        Permission::firstOrCreate(['name' => 'manage_users']);
        Permission::firstOrCreate(['name' => 'view_reports']);
        Permission::firstOrCreate(['name' => 'edit_settings']);

        // --- Roles ---

        // Contoh Role 'Super Admin'
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        // Berikan semua permission yang ada kepada 'Super Admin'
        $superAdminRole->givePermissionTo(Permission::all());

        
         
        $user = User::firstOrCreate(
            ['nik' => 'admin@admin.com'],
            ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin')]
        );
        $user->assignRole('super_admin');
    }
}