<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farming extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'country_id',
        'state_id',
        'district_id',
        'block_id',
        'gram_panchyat_id',
        'village_id',
        'age',
        'gender',
        'qualification',
        'land_holding',
        'language',
        'sms_mode',
        'created_by',
        'farmer_id',
        'is_validate',
        'post_office',
        'police_station',
        'registration_no',
        'father_name',
        'zone_id',
        'center_id',
        'g_code',
        'seed_category_id',
        'finance_category',
        'account_number',
        'bank',
        'branch',
        'ifsc_code',
        'land_type',
        'offered_area',
        'is_irregation',
        'irregation',
        'non_loan_type',
        'account_no_ifsc',
        'name_of_cooperative',
        'cooperative_address',
    ];

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

    public function zone()
    {
        return $this->belongsTo(Zone::class,'zone_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class,'center_id');
    }

    public function seed_category()
    {
        return $this->belongsTo(SeedCategory::class,'seed_category_id');
    }
}
