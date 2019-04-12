<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_operacion', 30);
            $table->text('description');
            $table->unsignedInteger('note_id');
            $table->foreign('note_id')->references('id')
                ->on('ventas')->onDelete('cascade');
            $table->unsignedInteger('venta_id');
            $table->foreign('venta_id')->references('id')
                ->on('ventas')->onDelete('cascade');

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
        Schema::dropIfExists('notes');
    }
}
