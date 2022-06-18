<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductCart;
use App\Models\ProductLike;
use App\Models\ProductOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = array(
        'category_id',
        'slug',
        'name',
        'image',
        'publish_status',
        'description',
        'qty',
        'price',
        'discount_price',
        'view_count',
    );

    public function category() {
        return $this->belongsTo( Category::class );
    }

    public function order() {
        return $this->hasMany( ProductOrder::class );
    }

    public function cart() {
        return $this->hasMany( ProductCart::class );
    }

    public function favourite() {
        return $this->hasMany( ProductLike::class );
    }
}
