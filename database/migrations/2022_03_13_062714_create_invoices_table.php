<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->integer('batch_number');
            $table->string('invoice_for');
            $table->string('invoice_type');
            $table->string('invoice_month_year');
            $table->date('invoice_date');
            $table->date('invoice_from_date');
            $table->date('invoice_to_date');
            $table->date('invoice_due_date');
            $table->double('sub_total');
            $table->string('client_vat');
            $table->double('total_amount', 13, 2);
            $table->string('invoice_generated_by');
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
        Schema::dropIfExists('invoices');
    }
}
