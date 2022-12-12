<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $userPermissions = [];
        foreach($permissions as $permission){
            $userPermissions[]= $permission->name;
        }

        $userPermissions = json_encode($userPermissions);
        UserPermission::create([
            'user_id' => 1,
            'permissions' => $userPermissions,
            'created_by' => 1,
            'updated_by' => 1
        ]);
    }
}
