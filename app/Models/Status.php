<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class Status
 *
 * @property string content
 * @property int user_id
 * @property User user
 * @property string create_at
 * @property string updated_at
 */
class Status extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['countent'];

    /**
     * The attributes that are mass assignable.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        // 一条微博属于一个用户,1 属于 1 的关系,因此使用BelongsTo
        return $this->belongsTo(User::class);
    }
}
