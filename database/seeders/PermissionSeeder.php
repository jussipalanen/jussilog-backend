<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        if (Permission::exists()) {
            $this->command->info('PermissionSeeder: permissions already seeded, skipping.');

            return;
        }

        $definitions = [
            // group              name                        label
            ['blogs',             'view_blogs',               'View Blogs'],
            ['blogs',             'edit_blogs',               'Edit Blogs'],
            ['blogs',             'delete_blogs',             'Delete Blogs'],

            ['blog_categories',   'view_blog_categories',     'View Blog Categories'],
            ['blog_categories',   'edit_blog_categories',     'Edit Blog Categories'],
            ['blog_categories',   'delete_blog_categories',   'Delete Blog Categories'],

            ['skill_categories',  'view_skill_categories',    'View Skill Categories'],
            ['skill_categories',  'edit_skill_categories',    'Edit Skill Categories'],
            ['skill_categories',  'delete_skill_categories',  'Delete Skill Categories'],

            ['skills',            'view_skills',              'View Skills'],
            ['skills',            'edit_skills',              'Edit Skills'],
            ['skills',            'delete_skills',            'Delete Skills'],

            ['languages',         'view_languages',           'View Languages'],
            ['languages',         'edit_languages',           'Edit Languages'],
            ['languages',         'delete_languages',         'Delete Languages'],

            ['orders',            'view_orders',              'View Orders'],
            ['orders',            'edit_orders',              'Edit Orders'],
            ['orders',            'delete_orders',            'Delete Orders'],

            ['invoices',          'view_invoices',            'View Invoices'],
            ['invoices',          'edit_invoices',            'Edit Invoices'],
            ['invoices',          'delete_invoices',          'Delete Invoices'],

            ['products',          'view_products',            'View Products'],
            ['products',          'edit_products',            'Edit Products'],
            ['products',          'delete_products',          'Delete Products'],

            ['users',             'view_users',               'View Users'],
            ['users',             'edit_users',               'Edit Users'],
            ['users',             'delete_users',             'Delete Users'],

            ['resumes',           'view_resumes',             'View Resumes'],
            ['resumes',           'edit_resumes',             'Edit Resumes'],
            ['resumes',           'delete_resumes',           'Delete Resumes'],
        ];

        $permissions = [];
        foreach ($definitions as [$group, $name, $label]) {
            $permissions[] = Permission::create(compact('group', 'name', 'label'));
        }

        $this->command->info('PermissionSeeder: '.count($permissions).' permissions created.');

        // ── Assign defaults to vendor and customer roles ───────────────────────
        // Admin bypasses all permission checks in middleware — no DB assignment needed.

        $vendor = Role::where('name', 'vendor')->first();
        if ($vendor) {
            $vendorPermissions = collect($permissions)
                ->whereIn('name', [
                    'view_products', 'edit_products',
                    'view_orders',   'edit_orders',
                    'view_invoices', 'edit_invoices', 'delete_invoices',
                ])
                ->pluck('id')
                ->all();
            $vendor->permissions()->sync($vendorPermissions);
            $this->command->info('PermissionSeeder: vendor permissions assigned.');
        }

        $customer = Role::where('name', 'customer')->first();
        if ($customer) {
            $customerPermissions = collect($permissions)
                ->whereIn('name', [
                    'view_orders',
                    'view_invoices',
                ])
                ->pluck('id')
                ->all();
            $customer->permissions()->sync($customerPermissions);
            $this->command->info('PermissionSeeder: customer permissions assigned.');
        }
    }
}
