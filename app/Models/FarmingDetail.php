<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'farming_id',
        'name',
        'plot_number',
        'kata_number',
        'area_in_acar',
        'date_of_harvesting',
        'quantity',
        'seed_category_id',
        'tentative_harvest_quantity',
        'created_by',
        'type',
        'block_id',
        'gram_panchyat_id',
        'village_id',
        'zone_id',
        'center_id',
    ];
    
    public function farming()
    {
        return $this->belongsTo(Farming::class,'farming_id');
    }
    public function seed_category()
    {
        return $this->belongsTo(SeedCategory::class,'seed_category_id');
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
}
