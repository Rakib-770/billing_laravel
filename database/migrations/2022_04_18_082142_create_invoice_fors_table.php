<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInvoiceForsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_fors', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_for');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });

        DB::table('invoice_fors')->insert([
            ['invoice_for' => 'Coloasia'],
            ['invoice_for' => 'MCloud'],
            ['invoice_for' => 'Bogra POI'],
            ['invoice_for' => 'Sylhet POI'],
            ['invoice_for' => 'SMS']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_fors');
    }
}
