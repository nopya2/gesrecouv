<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelaunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaunches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->dateTime('date_relaunch')->nullable();

            $table->unsignedBigInteger('facture_id')->nullable();
            $table->foreign('facture_id')
                ->references('id')->on('factures')
                ->onDelete('set null');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')
                ->references('id')->on('clients')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->string('mode_relance')->default('phone');
            $table->text('commentaire')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relaunches');
    }
}
