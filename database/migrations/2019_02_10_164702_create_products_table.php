<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique();
            $table->string('name', 200);
            $table->decimal('price', 7, 2)->default(0.00);
            $table->text('description');
            $table->integer('quantity')->default(0);
            $table->integer('unity')->nullable('Kg');
            $table->string('img');
            $table->enum('status', ['available', 'unavailable']);
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
