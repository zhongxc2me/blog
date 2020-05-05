<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    /**
     * 获取关注了我的所有粉丝
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follower()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower');
    }

    /**
     * 获取所有关注
     * 查询关注我的粉丝都关注了谁
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followeing()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower', 'user_id');
    }

    /**
     * 查看指定用户是否为我的粉丝
     * @param $uid
     * @return mixed
     */
    public function isFollow($uid)
    {
        return $this->follower()->wherePivot('follower', $uid)->first();
    }

    /**
     * 关注或者取消关注
     * @param $ids
     * @return array
     */
    public function followToggle($ids)
    {
        $ids = is_array($ids) ?: [$ids];
        return $this->follower()->withTimestamps()->toggle($ids);
    }
}
