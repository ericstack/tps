<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';

    protected $fillable = [
        'control_number',
        'order_id',
        'customer_name',
        'address',
        'employee_id',
        'status',
    ];

    // Surface the parent order's code so the SPA can show it read-only.
    protected $appends = ['order_code'];

    public function getOrderCodeAttribute(): ?string
    {
        return $this->order?->order_code;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
