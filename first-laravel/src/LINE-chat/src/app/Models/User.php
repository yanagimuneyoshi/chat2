<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 自分が作成したトーク
    public function talks()
    {
        return $this->hasMany(Talk::class);
    }

    // 自分が送信したメッセージ
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // 自分の友達リスト
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }
}

