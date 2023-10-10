<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'title', 'provider_id', 'user_id', 'received_date'
    ];

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products() // 복수형으로 hasMany를 쉽게 알 수 있게 했다.
    {
        return $this->hasMany('App\ReceivedProduct');
    }
}
