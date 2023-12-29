<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerLoan extends Model
{
    use HasFactory; 

    protected $fillable = [
        'farming_id',
        'registration_number',
        'agreement_number',
        'loan_category_id',
        'loan_type_id',
        'price_kg',
        'quantity',
        'total_amount',
        'date',
        'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(ProductServiceCategory::class,'loan_category_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductService::class,'loan_type_id');
    }

    public function farming()
    {
        return $this->belongsTo(Farming::class,'farming_id');
    }

}
