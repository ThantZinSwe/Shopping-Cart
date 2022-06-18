<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'product_orders', function ( Blueprint $table ) {
            $table->id();
            $table->foreignIdFor( User::class )->constrained()->onDelete( 'cascade' );
            $table->foreignIdFor( Product::class )->constrained()->onDelete( 'cascade' );
            $table->integer( 'qty' );
            $table->enum( 'status', array( 'pending', 'complete' ) );
            $table->string( 'phone' );
            $table->longText( 'address' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'product_orders' );
    }
};
