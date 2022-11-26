<?php

namespace App\Api\Models;

use App\Api\Core\Traits\UuidTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AccountTypeModel extends Authenticatable
{
    use UuidTrait;

    /**
     * MODEL CONSTANTS
     */
    const ADMIN = 'admin';
    const MODERATOR = 'moderator';
    const MEMBER = 'member';

    /**
     * @var string
     */
    protected $table = 'account_types';

    /**
     * @var array<string>
     */
    protected $hidden = [
        'id',
        'laravel_through_key'
    ];

    /**
     * @var array<string>
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'type',
    ];

    /**
     * Array of types
     *
     * @var array<string>
     */
    public static $types = [
        self::ADMIN,
        self::MODERATOR,
        self::MEMBER,
    ];

    public function userAccount()
    {
        return $this->hasMany(UserAccountModel::class, 'account_type_id');
    }
}
