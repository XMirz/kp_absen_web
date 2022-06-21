<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('presences', function (Blueprint $table) {
      $table->id();
      $table->enum('type', ['inArea', 'out', 'permit', 'diseased']);
      $table->string('checkInLocation');
      $table->string('checkOutLocation')->nullable();
      $table->timestamp('checkInTime')->nullable();
      $table->timestamp('checkOutTime')->nullable();
      $table->double('checkInDistance')->nullable();
      $table->double('checkOutDistance')->nullable();
      $table->boolean('isVerified')->default(false);
      $table->string('description')->nullable();
      $table->timestamps();
      $table->foreignId('user_id')->constrained('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('presences');
  }
};
