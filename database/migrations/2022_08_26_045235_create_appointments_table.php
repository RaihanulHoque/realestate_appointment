<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullableOnDelete();
            $table->string('appointment_address', 255);
            $table->decimal('measured_distance', 8, 2)->nullable();
            $table->date('appointment_date');
            $table->time('appointment_start_time');
            $table->time('departure_time_to_site_office')->nullable();
            $table->time('appointment_end_time')->nullable();
            $table->time('arrival_time_to_agent_office')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
