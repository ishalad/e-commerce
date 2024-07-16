<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HomePageSection extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'device_type', 'is_category', 'is_product', 'is_brand', 'section_type', 'category_ids', 'product_ids','brand_ids','is_active'];
    protected $casts = ['category_ids'=> 'array', 'product_ids'=> 'array', 'brand_ids'=> 'array'];

    
}
