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
    ];
    
    public function farming()
    {
        return $this->belongsTo(Farming::class,'farming_id');
    }
    public function seed_category()
    {
        return $this->belongsTo(SeedCategory::class,'seed_category_id');
    }
}
