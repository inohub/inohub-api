<?php

namespace App\Interfaces\BaseRepository;

interface BaseRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelClass(): string;

    /**
     * @return array
     */
    public function getSearchFields(): array;
}
