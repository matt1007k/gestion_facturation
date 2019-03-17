<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 100);
            $table->string('num_comprobante', 20)->unique();            
            $table->date('fecha_emision');
            $table->string('tipo_doc', 100);
            $table->string('num_doc', 12);
            $table->string('nombre', 200);
            $table->string('direccion', 200);
            $table->decimal('subtotal', 8, 2);
            $table->decimal('igv', 8, 2);
            $table->decimal('total', 8, 2);
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
        Schema::dropIfExists('ventas');
    }
}
