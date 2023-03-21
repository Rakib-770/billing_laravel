<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientBillInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_bill_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('service_id');
            $table->double('quantity');
            $table->double('unit_price');
            $table->date('available_from');
            $table->date('available_till');
            $table->string('status');
            $table->string('inserted_by');
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
        Schema::dropIfExists('client_bill_infos');
    }
}
