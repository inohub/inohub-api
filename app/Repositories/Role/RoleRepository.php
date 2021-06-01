<?php

namespace App\Repositories\Role;

use App\Repositories\Base\BaseRepository;
use PHPZen\LaravelRbac\Model\Role;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Role::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'users' => [
                'manyToMany',
                'user_id',
            ]
        ];
    }

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function getBySlug(string $slug)
    {
        return $this->startQuery()->where('slug', $slug)->first();
    }
}
