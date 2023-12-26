<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'farming_id',
        'father_name',
        'registration_number',
        'country_id',
        'state_id',
        'district_id',
        'block_id',
        'gram_panchyat_id',
        'village_id',
        'age',
        'created_by',
        'post_office',
        'police_station',
    ];
    
    public function farming()
    {
        return $this->belongsTo(Farming::class,'farming_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class,'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class,'block_id');
    }

    public function gram_panchyat()
    {
        return $this->belongsTo(GramPanchyat::class,'gram_panchyat_id');
    }
    
    public function village()
    {
        return $this->belongsTo(Village::class,'village_id');
    }
}
