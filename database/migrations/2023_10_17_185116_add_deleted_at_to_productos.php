<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->softDeletes(); // Esto agrega el campo 'deleted_at'
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Esto revierte la operación en caso de un rollback
        });
    }
    
};
