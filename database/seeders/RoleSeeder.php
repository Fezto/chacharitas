<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Crear un rol 'superadmin'
        $role = Role::create(['name' => 'superadmin']);

// Crear un permiso 'access panel'
        $permission = Permission::create(['name' => 'access panel']);

// Asignar el permiso al rol
        $role->givePermissionTo($permission);

// Encontrar el primer usuario (supuestamente el superadmin)
        $superadmin = User::find(1);

// Asignar el rol 'superadmin' al usuario
        $superadmin->assignRole('superadmin');
    }
}
