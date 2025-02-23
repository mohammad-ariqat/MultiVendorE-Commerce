<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
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
        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);
        $vendorRole = Role::create(['name' => RolesEnum::Vendor->value]);

        $ApproveVendors = Permission::create(['name' => PermissionsEnum::ApproveVendors->value]);
        $SellProducts = Permission::create(['name' => PermissionsEnum::SellProducts->value]);
        $BuyProducts = Permission::create(['name' => PermissionsEnum::BuyProducts->value]);

        $userRole->syncPermissions([$BuyProducts]);
        $adminRole->syncPermissions([$ApproveVendors, $SellProducts, $BuyProducts]);
        $vendorRole->syncPermissions([$SellProducts, $BuyProducts]);
    }
}
