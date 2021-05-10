<?php

namespace App\Repositories\Test;

use App\Models\Test\Test;
use App\Repositories\Base\BaseRepository;
use Illuminate\Http\Request;

/**
 * Class TestRepository
 * @package App\Repositories\Test
 */
class TestRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Test::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'lesson'    => [
                'belongsTo',
                'lesson_id',
            ],
            'questions' => [
                'hasMany',
                'question_id',
            ]
        ];
    }

//    /**
//     * @param Request $request
//     *
//     * @return \Illuminate\Database\Eloquent\Builder
//     */
//    public function filters(Request $request)
//    {
//        return parent::filters($request)->withTrashed();
//    }
}
