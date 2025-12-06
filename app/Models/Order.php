<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'order_number', 'amount', 'status', 'order_date'];

    /**
     * Cast attributes to proper types.
     */
    protected $casts = [
        'order_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the customer associated with this order
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
