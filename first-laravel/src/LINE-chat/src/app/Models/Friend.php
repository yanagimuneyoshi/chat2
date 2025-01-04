<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'friend_id',
  ];

  // フレンドリレーション: 自分
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  // フレンドリレーション: 友達
  public function friend()
  {
    return $this->belongsTo(User::class, 'friend_id');
  }
}
