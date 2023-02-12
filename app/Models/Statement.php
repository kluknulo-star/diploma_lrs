<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Json;
use Ramsey\Uuid\Uuid;

/**
 * @property Json $content
 * @property integer $statement_id
 */
class Statement extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'statements';

    /**
     * Первичный ключ таблицы БД.
     *
     * @var int
     */
    protected $primaryKey = 'statement_id';

    /**
     * Атрибуты, которые должны быть типизированы.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];

    protected $fillable = [
        'uuid'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
