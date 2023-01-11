<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributeNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribute_notes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('contributer_id');
            $table->foreign('contributer_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('contributed_id');
            $table->foreign('contributed_id')->references('id')->on('users')->onDelete('cascade');


            $table->unsignedBigInteger('note_id');
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');

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
        Schema::dropIfExists('contribute_notes');
    }
}
