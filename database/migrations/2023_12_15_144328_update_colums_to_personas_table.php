<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Delete a new foreing key
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['documento_id']);
            $table->dropColumn('documento_id');
        });

        //Create a new foreign key
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('documento_id')->after('estado')->constrained('documentos')->onDelete('cascade');
        });

        //Create a new foreign key
        Schema::table('personas', function (Blueprint $table) {
            $table->string('numero_documento', 20)->after('documento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //delete a new foreign key
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['documento_id']);
            $table->dropColumn('documento_id');
        });

        //Create a new foreing key
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('documento_id')->after('estado')->unique('documentos')->onDelete('cascade');
        });



        //Eliminar el campo numero de documento
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('numero_documento');
        });
    }
};
