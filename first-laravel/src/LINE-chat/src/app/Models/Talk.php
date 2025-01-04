<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'message',
    'user_id',
  ];



  // トークの作成者
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // トークに関連するメッセージ
  public function messages()
  {
    return $this->hasMany(Message::class);
  }
}
