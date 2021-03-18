<?php

namespace Database\Seeders\User;

use App\Models\User\User;
use Illuminate\Database\Seeder;

/**
 * Class UserSeed
 * @package Database\Seeders\User
 */
class UserSeed extends Seeder
{
    public function run()
    {
        self::createUser(10);
    }

    /**
     * @param $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createUser($num)
    {
        return User::factory($num)->make()->each(function (User $user) {
            //доп логика жазад обычно типа роль сет дегендей
            //если ондай керек емес боса можно сразу сохранять и удалить устынгы анонимный функцияны
            $user->save();
        });
    }
}
