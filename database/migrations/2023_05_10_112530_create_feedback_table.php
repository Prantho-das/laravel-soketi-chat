<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->text("message");
            $table->boolean("is_read")->default(false);
            $table->boolean("is_responded")->default(false);
            $table->string("responded_by")->nullable();
            $table->text("response")->nullable();
            $table->timestamp("responded_at")->nullable();
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
        Schema::dropIfExists('feedback');
    }
}