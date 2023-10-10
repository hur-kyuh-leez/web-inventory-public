<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Transaction extends Model
{
    // Task Table에 있는 거 그냥 나열
    protected $fillable = [
        'title', 'reference', 'amount', 'payment_method_id', 'type', 'client_id', 'user_id', 'sale_id', 'provider_id', 'transfer_id', 'selected_date'
    ];

    public function method()
    {
        return $this->belongsTo('App\PaymentMethod', 'payment_method_id'); // PaymentMethod 라는 Model에 있는
    }

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }

    public function client()
    {
        return $this->belongsTo('App\Client')->withTrashed();
    }

    public function transfer()
    {
        return $this->belongsTo('App\Transfer');
    }

    public function scopeFindByPaymentMethodId($query, $id)
    {
        return $query->where('payment_method_id', $id);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month);
    }
}
