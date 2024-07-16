<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
