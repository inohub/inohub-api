<?php

namespace App\Services\User;

use App\Models\User\User;
use App\Repositories\Role\RoleRepository;

/**
 * Class UserAttachRoleService
 * @property User   $user
 * @property string $slug
 * @package App\Services\User
 */
class UserAttachRoleService
{
    private User $user;
    private string $slug;

    /**
     * UserAttachRoleService constructor.
     *
     * @param User   $user
     * @param string $slug
     */
    public function __construct(User $user, string $slug)
    {
        $this->user = $user;
        $this->slug = $slug;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $role = app(RoleRepository::class)->getBySlug($this->slug);

        try {
            $this->user->roles()->syncWithoutDetaching($role->id);

            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
