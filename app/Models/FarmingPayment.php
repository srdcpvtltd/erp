<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'farming_id',
        'registration_number',
        'agreement_number',
        'date',
        'amount',
        'created_by',
    ];

    public function farming()
    {
        return $this->belongsTo(Farming::class,'farming_id');
    }

    
}