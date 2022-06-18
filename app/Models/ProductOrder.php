<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model {
    use HasFactory;

    protected $fillable = array(
        'user_id',
        'product_id',
        'qty',
        'status',
        'phone',
        'address',
    );

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function product() {
        return $this->belongsTo( Product::class );
    }
}
