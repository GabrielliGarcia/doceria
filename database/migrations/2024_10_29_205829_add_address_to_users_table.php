<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->string('telefone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rua', 'numero', 'bairro', 'cep', 'telefone']);
        });
    }

};
