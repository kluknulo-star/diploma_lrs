<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExcelExport extends Model
{
    use HasFactory;

    protected $table = 'exports';
    protected $primaryKey = 'export_id';
    protected $fillable = ['file_path', 'user_id', 'percent_of_work', 'export_filter'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
