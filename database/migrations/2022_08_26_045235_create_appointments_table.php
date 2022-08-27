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
            $table->increments('id');
            $table->unsignedInteger('contact_id')->comment('The customer ID');
            $table->unsignedInteger('user_id')->nullable()->comment('The Appointed By person');
            $table->string('appointment_address');
            $table->string('measured_distance')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_start_time');
            $table->time('departure_time_to_site_office')->nullable()->comment('Time calculation for Estimated Time of Departure from office to the Appointment Addres, which is the RealEstate Office');
            $table->time('appointment_end_time')->nullable();
            $table->time('arrival_time_to_agent_office')->nullable()->comment('Time calculation for Estimated Time of Arrival to the Agent Office from the Real Estate office');
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
