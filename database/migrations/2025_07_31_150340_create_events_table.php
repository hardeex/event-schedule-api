
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->unsignedInteger('max_participants');
            $table->timestamps();                   
            $table->index(['start_datetime', 'end_datetime']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};

