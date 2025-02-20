<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property string activation_token
 * @property bool activated
 * @property bool is_admin
 * @property Status[] statuses
 * @property string email_verified_at
 * @property string remember_token
 * @property string created_at
 * @property string updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 监听用户创建事件, 在用户创建时自动生成激活令牌
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    /**
     * 通过邮箱到 gravatar.com 获取头像
     *
     * @param string $size
     * @return string
     */
    public function gravatar(string $size = '100'): string
    {
        $hash = md5(trim(strtolower($this->attributes['email'])));
        return "https://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * The user has many statuses.
     *
     * @return HasMany
     */
    public function statuses(): HasMany
    {
        // 一个用户拥有多条微博, 一对多关系
        return $this->hasMany(Status::class);
    }

    /**
     * 获取用户的微博动态流, 包括本人和所关注用户的动态
     */
    public function feed()
    {
        $user_ids = $this->followings->pluck('id')->toArray();
        $user_ids[] = $this->id;
        return Status::whereIn('user_id', $user_ids)
            ->with('user')
            ->orderBy('created_at', 'desc');
    }

    /**
     * The user has many followers.
     *
     * @return BelongsToMany
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * The user has many followings.
     *
     * @return BelongsToMany
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Follow a user.
     *
     * @param $user_ids
     */
    public function follow($user_ids): void
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        // attach() 在中间表中插入数据
        // sync() 同步中间表中的数据和传入的数据
        // detach() 在中间表中删除数据
        // student 表, course 表, student_course 表, 处理 student_course 表
        // 在我们这个地方, users 表, users 表, followers 表, 处理 followers 表

        $this->followings()->sync($user_ids, false);
    }

    /**
     * Unfollow a user.
     *
     * @param $user_ids
     */
    public function unfollow($user_ids): void
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followings()->detach($user_ids);
    }

    /**
     * Determine if the current user is following the given user.
     *
     * @param $user_id
     * @return bool
     */
    public function isFollowing($user_id): bool
    {
        // contains() 判断集合中是否包含给定的键
        return $this->followings->contains($user_id);
    }
}
