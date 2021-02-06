<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo', function (Blueprint $table) {

            $table->id();
            $table->string('nombre');
            $table->longText('descripcion');
            $table->longText('codigo');
            $table->integer('stock');
            $table->decimal('precio_unitario',8,2);
            $table->decimal('precio_venta',8,2);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                $table->foreign('categoria_id')
                ->references('id')
                ->on('categoria')
                ->onDelete('cascade');
            $table->foreign('proveedor_id')
                ->references('id')
                ->on('proveedor')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo');
    }
}
