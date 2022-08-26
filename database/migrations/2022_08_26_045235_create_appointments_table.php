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
            $table->unsignedInteger('user_id')->comment('The Appointed By person');
            $table->string('appointment_address');
            $table->string('measured_distance');
            $table->date('appointment_date');
            $table->time('appointment_start_time');
            $table->string('departure_time_to_site_office')->nullable()->comment('Time calculation for Estimated Time of Departure from office to the Appointment Addres, which is the RealEstate Office');
            $table->dateTime('appointment_end_time');
            $table->string('departure_time_to_agent_office')->nullable()->comment('Time calculation for Estimated Time of Departure from the Real Estate office to the Agent Office');
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            
            $table->foreign('contact_id')
            ->references('id')
            ->on('contacts')
            ->onDelete('cascade');
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
