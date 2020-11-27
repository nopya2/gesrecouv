<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePivotDocumentFacture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_facture', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('facture_id');
            $table->foreign('facture_id')
                ->references('id')->on('factures')
                ->onDelete('cascade');

            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')
                ->references('id')->on('documents');
                // ->onDelete('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_pivot_document_facture');
    }
}
