<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToPivotDocumentPaiementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_paiement', function (Blueprint $table) {
            $table->unsignedBigInteger('paiement_id');
            $table->foreign('paiement_id')
                ->references('id')->on('paiements')
                ->onDelete('cascade');

            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')
                ->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_paiement', function (Blueprint $table) {
            //
        });
    }
}
