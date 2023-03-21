<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_infos', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_address');
            $table->string('invoice_contact_person')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('client_bin_number')->nullable();
            $table->string('client_nid')->nullable();
            $table->string('client_po_number')->nullable();
            $table->string('client_vat');
            $table->string('invoice_type');
            $table->string('client_type')->nullable();
            $table->string('service_location')->nullable();
            $table->date('client_activation_date')->nullable();
            $table->date('client_inactivation_date')->nullable();
            $table->string('invoice_for');
            $table->string('status');
            $table->double('mrc_tk')->nullable();
            $table->string('client_entry_by');
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
        Schema::dropIfExists('client_infos');
    }
}
