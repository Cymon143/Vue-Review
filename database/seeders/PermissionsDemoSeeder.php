<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // run this command
        // php artisan migrate:fresh --seed --seeder=PermissionsDemoSeeder
        // php artisan db:seed
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Role::create(['guard_name' => 'admin', 'name' => 'manager']);
        // $permission = Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);

        Permission::create(['guard_name' => 'api','name' => 'edit user']);
        Permission::create(['guard_name' => 'api','name' => 'delete user']);
        Permission::create(['guard_name' => 'api','name' => 'create user']);
        Permission::create(['guard_name' => 'api','name' => 'access user']);
        Permission::create(['guard_name' => 'api','name' => 'list user']);
        Permission::create(['guard_name' => 'api','name' => 'show user']);

        Permission::create(['guard_name' => 'api','name' => 'edit permission']);
        Permission::create(['guard_name' => 'api','name' => 'delete permission']);
        Permission::create(['guard_name' => 'api','name' => 'create permission']);
        Permission::create(['guard_name' => 'api','name' => 'access permission']);
        Permission::create(['guard_name' => 'api','name' => 'list permission']);
        Permission::create(['guard_name' => 'api','name' => 'show permission']);

        Permission::create(['guard_name' => 'api','name' => 'edit role']);
        Permission::create(['guard_name' => 'api','name' => 'delete role']);
        Permission::create(['guard_name' => 'api','name' => 'create role']);
        Permission::create(['guard_name' => 'api','name' => 'access role']);
        Permission::create(['guard_name' => 'api','name' => 'list role']);
        Permission::create(['guard_name' => 'api','name' => 'show role']);

        Permission::create(['guard_name' => 'api','name' => 'edit major']);
        Permission::create(['guard_name' => 'api','name' => 'delete major']);
        Permission::create(['guard_name' => 'api','name' => 'create major']);
        Permission::create(['guard_name' => 'api','name' => 'access major']);
        Permission::create(['guard_name' => 'api','name' => 'list major']);
        Permission::create(['guard_name' => 'api','name' => 'show major']);

        Permission::create(['guard_name' => 'api','name' => 'edit subject']);
        Permission::create(['guard_name' => 'api','name' => 'delete subject']);
        Permission::create(['guard_name' => 'api','name' => 'create subject']);
        Permission::create(['guard_name' => 'api','name' => 'access subject']);
        Permission::create(['guard_name' => 'api','name' => 'list subject']);
        Permission::create(['guard_name' => 'api','name' => 'show subject']);

        Permission::create(['guard_name' => 'api','name' => 'edit section']);
        Permission::create(['guard_name' => 'api','name' => 'delete section']);
        Permission::create(['guard_name' => 'api','name' => 'create section']);
        Permission::create(['guard_name' => 'api','name' => 'access section']);
        Permission::create(['guard_name' => 'api','name' => 'list section']);
        Permission::create(['guard_name' => 'api','name' => 'show section']);

        Permission::create(['guard_name' => 'api','name' => 'edit schedule']);
        Permission::create(['guard_name' => 'api','name' => 'delete schedule']);
        Permission::create(['guard_name' => 'api','name' => 'create schedule']);
        Permission::create(['guard_name' => 'api','name' => 'access schedule']);
        Permission::create(['guard_name' => 'api','name' => 'list schedule']);
        Permission::create(['guard_name' => 'api','name' => 'show schedule']);

        Permission::create(['guard_name' => 'api','name' => 'edit level-subject']);
        Permission::create(['guard_name' => 'api','name' => 'delete level-subject']);
        Permission::create(['guard_name' => 'api','name' => 'create level-subject']);
        Permission::create(['guard_name' => 'api','name' => 'access level-subject']);
        Permission::create(['guard_name' => 'api','name' => 'list level-subject']);
        Permission::create(['guard_name' => 'api','name' => 'show level-subject']);

        Permission::create(['guard_name' => 'api','name' => 'edit substitution']);
        Permission::create(['guard_name' => 'api','name' => 'delete substitution']);
        Permission::create(['guard_name' => 'api','name' => 'create substitution']);
        Permission::create(['guard_name' => 'api','name' => 'access substitution']);
        Permission::create(['guard_name' => 'api','name' => 'list substitution']);
        Permission::create(['guard_name' => 'api','name' => 'show substitution']);

        Permission::create(['guard_name' => 'api','name' => 'edit settings']);
        Permission::create(['guard_name' => 'api','name' => 'delete settings']);
        Permission::create(['guard_name' => 'api','name' => 'create settings']);
        Permission::create(['guard_name' => 'api','name' => 'access settings']);
        Permission::create(['guard_name' => 'api','name' => 'list settings']);
        Permission::create(['guard_name' => 'api','name' => 'show settings']);
        Permission::create(['guard_name' => 'api','name' => 'school year settings']);
        Permission::create(['guard_name' => 'api','name' => 'substitution status settings']);
        Permission::create(['guard_name' => 'api','name' => 'principal settings']);
        Permission::create(['guard_name' => 'api','name' => 'school name settings']);
        Permission::create(['guard_name' => 'api','name' => 'encoding of schedule settings']);
        Permission::create(['guard_name' => 'api','name' => 'school logo settings']);

        Permission::create(['guard_name' => 'api','name' => 'access schedule search']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'api','name' => 'user']);
        // $role1->givePermissionTo('access user');
        // $role1->givePermissionTo('show user');
        // $role1->givePermissionTo('list user');

        $role2 = Role::create(['guard_name' => 'api','name' => 'admin']);
        $role2->givePermissionTo('delete user');
        $role2->givePermissionTo('edit user');
        $role2->givePermissionTo('access user');
        $role2->givePermissionTo('show user');
        $role2->givePermissionTo('create user');
        $role2->givePermissionTo('list user');

        $role2->givePermissionTo('delete settings');
        $role2->givePermissionTo('edit settings');
        $role2->givePermissionTo('access settings');
        $role2->givePermissionTo('show settings');
        $role2->givePermissionTo('create settings');
        $role2->givePermissionTo('list settings');
        $role2->givePermissionTo('school year settings');
        $role2->givePermissionTo('principal settings');
        $role2->givePermissionTo('substitution status settings');
        $role2->givePermissionTo('school name settings');
        $role2->givePermissionTo('encoding of schedule settings');
        $role2->givePermissionTo('school logo settings');

        $role2->givePermissionTo('delete level-subject');
        $role2->givePermissionTo('edit level-subject');
        $role2->givePermissionTo('access level-subject');
        $role2->givePermissionTo('show level-subject');
        $role2->givePermissionTo('create level-subject');
        $role2->givePermissionTo('list level-subject');

        $role2->givePermissionTo('delete section');
        $role2->givePermissionTo('edit section');
        $role2->givePermissionTo('access section');
        $role2->givePermissionTo('show section');
        $role2->givePermissionTo('create section');
        $role2->givePermissionTo('list section');

        $role2->givePermissionTo('access schedule search');
        // $role2->givePermissionTo('edit schedule search');
        // $role2->givePermissionTo('access schedule search');
        // $role2->givePermissionTo('show schedule search');
        // $role2->givePermissionTo('create schedule search');
        // $role2->givePermissionTo('list schedule search');

        $role2->givePermissionTo('delete subject');
        $role2->givePermissionTo('edit subject');
        $role2->givePermissionTo('access subject');
        $role2->givePermissionTo('show subject');
        $role2->givePermissionTo('create subject');
        $role2->givePermissionTo('list subject');

        $role2->givePermissionTo('delete major');
        $role2->givePermissionTo('edit major');
        $role2->givePermissionTo('access major');
        $role2->givePermissionTo('show major');
        $role2->givePermissionTo('create major');
        $role2->givePermissionTo('list major');

        $role2->givePermissionTo('delete schedule');
        $role2->givePermissionTo('edit schedule');
        $role2->givePermissionTo('access schedule');
        $role2->givePermissionTo('show schedule');
        $role2->givePermissionTo('create schedule');
        $role2->givePermissionTo('list schedule');

        $role2->givePermissionTo('edit substitution');
        $role2->givePermissionTo('delete substitution');
        $role2->givePermissionTo('create substitution');
        $role2->givePermissionTo('access substitution');
        $role2->givePermissionTo('list substitution');
        $role2->givePermissionTo('show substitution');

        // $role2->givePermissionTo('delete permission');
        // $role2->givePermissionTo('edit permission');
        // $role2->givePermissionTo('access permission');
        // $role2->givePermissionTo('show permission');
        // $role2->givePermissionTo('create permission');
        // $role2->givePermissionTo('list permission');

        // $role2->givePermissionTo('delete role');
        // $role2->givePermissionTo('edit role');
        // $role2->givePermissionTo('access role');
        // $role2->givePermissionTo('show role');
        // $role2->givePermissionTo('create role');
        // $role2->givePermissionTo('list role');

        $role3 = Role::create(['guard_name' => 'api','name' => 'Super-Admin']);
        $role3->givePermissionTo('delete user');
        $role3->givePermissionTo('edit user');
        $role3->givePermissionTo('access user');
        $role3->givePermissionTo('show user');
        $role3->givePermissionTo('create user');
        $role3->givePermissionTo('list user');

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        \App\Models\Major::factory()->create([
            'name' => 'English',
            'preferable' => null,
        ]);
        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'major_id' => 1,
        ]);
        $user->assignRole($role1);
        // $user->givePermissionTo('edit major');
        // $user->givePermissionTo('delete major');
        // $user->givePermissionTo('create major');
        // $user->givePermissionTo('access major');
        // $user->givePermissionTo('list major');
        // $user->givePermissionTo('show major');

        // $user->givePermissionTo('edit subject');
        // $user->givePermissionTo('delete subject');
        // $user->givePermissionTo('create subject');
        // $user->givePermissionTo('access subject');
        // $user->givePermissionTo('list subject');
        // $user->givePermissionTo('show subject');

        // $user->givePermissionTo('edit section');
        // $user->givePermissionTo('delete section');
        // $user->givePermissionTo('create section');
        // $user->givePermissionTo('access section');
        // $user->givePermissionTo('list section');
        // $user->givePermissionTo('show section');

        $user->givePermissionTo('edit schedule');
        $user->givePermissionTo('delete schedule');
        $user->givePermissionTo('create schedule');
        $user->givePermissionTo('access schedule');
        $user->givePermissionTo('list schedule');
        $user->givePermissionTo('show schedule');

        // $user->givePermissionTo('edit substitution');
        // $user->givePermissionTo('delete substitution');
        // $user->givePermissionTo('create substitution');
        // $user->givePermissionTo('access substitution');
        // $user->givePermissionTo('list substitution');
        // $user->givePermissionTo('show substitution');


        // $user->givePermissionTo('edit level-subject');
        // $user->givePermissionTo('delete level-subject');
        // $user->givePermissionTo('create level-subject');
        // $user->givePermissionTo('access level-subject');
        // $user->givePermissionTo('list level-subject');
        // $user->givePermissionTo('show level-subject');

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
            'major_id' => 1,
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
            'major_id' => 1,
        ]);
        $user->assignRole($role3);
    }
}
