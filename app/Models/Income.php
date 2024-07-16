<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['income_category_id', 'amount'];

    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class);
    }
}
