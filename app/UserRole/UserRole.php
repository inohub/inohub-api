<?php

namespace App\UserRole;

/**
 * Class UserRole
 * @package App\UserRole
 */
class UserRole
{
    const ADMIN    = 'admin';
    const GUEST    = 'guest';
    const STARTUP  = 'startup';
    const INVESTOR = 'investor';

    /**
     * @return string[]
     */
    public static function getName(): array
    {
        return [
            self::ADMIN    => 'Администратор',
            self::GUEST    => 'Гость',
            self::STARTUP  => 'Стартапер',
            self::INVESTOR => 'Инвестор',
        ];
    }
}
