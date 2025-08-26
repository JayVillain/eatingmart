<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'virtual_account_number',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items() // Perbaikan nama relasi dari 'orderItems' ke 'items'
    {
        return $this->hasMany(OrderItem::class);
    }
}