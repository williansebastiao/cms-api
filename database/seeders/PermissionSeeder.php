<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $permissions = [
            [
                "name" => "User",
                "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum",
                "color" => "rgb(114, 2, 248)",
                "route" => [
                    [
                        "name" => "Dashboard",
                        "role" => [
                        "read" => true,
                            "create" => false,
                            "edit" => false,
                            "delete" => false
                        ],
                        "slug" => Str::slug('Dashboard')
                    ],
                    [
                        "name" => "Users",
                        "role" => [
                        "read" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false
                        ],
                        "slug" => Str::slug('Users')
                    ],
                    [
                        "name" => "Roles",
                        "role" => [
                        "read" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false
                        ],
                        "slug" => Str::slug('Roles')
                    ],
                    [
                        "name" => "Chat",
                        "role" => [
                        "read" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false
                        ],
                        "slug" => Str::slug('Chat')
                    ]
                ],
                "active" => false,
                "slug" => "user"
            ],
            [
                "name" => "Administrator",
                "description" => "All Permissions",
                "color" => "#10ac84",
                "route" => [
                    [
                        "name" => "Dashboard",
                        "role" => [
                            "read" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true
                        ],
                        "slug" => Str::slug('Dashboard')
                    ],
                    [
                        "name" => "Users",
                        "role" => [
                            "read" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true
                        ],
                        "slug" => Str::slug('Users')
                    ],
                    [
                        "name" => "Roles",
                        "role" => [
                            "read" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true
                        ],
                        "slug" => Str::slug('Roles')
                    ],
                    [
                        "name" => "Chat",
                        "role" => [
                            "read" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true
                        ],
                        "slug" => Str::slug('Chat')
                    ]
                ],
                "active" => true,
                "slug" => "administrator"
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
