<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'employee_name',
        'address',
        'gender',
        'birthday',
    ];

    protected function casts(): array
    {
        return ['birthday' => 'date'];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
