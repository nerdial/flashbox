<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin' => [
                'add seller', 'list seller'
            ],
            'customer' => [
                'purchase product', 'list product'
            ],
            'seller' => [
                'list shop product', 'add product'
            ]
        ];

        foreach ($roles as $name => $permissions) {
            $role = Role::create(['name' => $name]);
            foreach ($permissions as $item){
                $permission = Permission::create(['name' => $item]);
                $permission->assignRole($role);
            }
        }

    }
}
