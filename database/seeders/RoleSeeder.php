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
        $admin = Role::create(['name' => 'admin']);
        $customer = Role::create(['name'=> 'customer']);
        $seller = Role::create(['name' => 'seller']);

        $addSellers = Permission::create(['name' => 'add sellers']);
        $listSellers = Permission::create(['name' => 'list sellers']);

        $addSellers->assignRole($admin);
        $listSellers->assignRole($admin);




    }
}
