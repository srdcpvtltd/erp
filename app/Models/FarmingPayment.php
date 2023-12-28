<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingPayment extends Model
{
    use HasFactory;

    const SECURITY_DEPOSIT = 'Share Deposit';
    const BANK_GUARANTEE = 'Bank Guarantee';

    protected $fillable = [
        'farming_id',
        'registration_number',
        'agreement_number',
        'date',
        'amount',
        'type',
        'created_by',
        'bank',
    ];

    public function farming()
    {
        return $this->belongsTo(Farming::class,'farming_id');
    }

    
}