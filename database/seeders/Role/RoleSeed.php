<?php

namespace Database\Seeders\Role;

use App\UserRole\UserRole;
use Illuminate\Database\Seeder;
use PHPZen\LaravelRbac\Model\Role;

/**
 * Class RoleSeed
 * @package Database\Seeders\Role
 */
class RoleSeed extends Seeder
{
    public function run()
    {
        self::createRole(UserRole::getName()[UserRole::ADMIN], UserRole::ADMIN);

        self::createRole(UserRole::getName()[UserRole::GUEST], UserRole::GUEST);

        self::createRole(UserRole::getName()[UserRole::STARTUP], UserRole::STARTUP);

        self::createRole(UserRole::getName()[UserRole::INVESTOR], UserRole::INVESTOR);
    }

    /**
     * @param string $name
     * @param string $slug
     */
    public static function createRole(string $name, string $slug)
    {
        $role = new Role();

        $role->name = $name;
        $role->slug = $slug;

        $role->save();
    }
}
