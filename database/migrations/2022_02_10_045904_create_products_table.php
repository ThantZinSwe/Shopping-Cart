<?php

use App\Models\Category;
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
        Schema::create( 'products', function ( Blueprint $table ) {
            $table->id();
            $table->foreignIdFor( Category::class )->constrained()->onDelete( 'cascade' );
            $table->string( 'slug' );
            $table->string( 'name' );
            $table->string( 'image' );
            $table->enum( 'publish_status', array( 'yes', 'no' ) );
            $table->integer( 'price' );
            $table->integer( 'discount_price' );
            $table->longText( 'description' );
            $table->integer( 'qty' );
            $table->integer( 'view_count' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'products' );
    }
};
