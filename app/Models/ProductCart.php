<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCart extends Model {
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'product_id',
        'qty',
    );

    public function product() {
        return $this->belongsTo( Product::class );
    }

    public function user() {
        return $this->belongsTo( User::class );
    }
}
