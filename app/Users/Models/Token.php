<?php

namespace App\Users\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $token_id
 * @property integer $user_id
 * @property string $token
 * @property string $expiration_date
 */
class Token extends  Model
{
    protected $primaryKey = 'token_id';

    protected $casts = [
        'expiration_date' => 'datetime',
    ];



}
