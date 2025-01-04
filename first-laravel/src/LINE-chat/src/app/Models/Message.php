<?php




  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Message extends Model
  {
  use HasFactory;

  protected $fillable=[ 'content' , 'user_id' , 'talk_id' ,
  ];

  // メッセージの送信者
  public function user()
  {
  return $this->belongsTo(User::class);
  }

  // メッセージが属するトーク
  public function talk()
  {
  return $this->belongsTo(Talk::class);
  }
  }