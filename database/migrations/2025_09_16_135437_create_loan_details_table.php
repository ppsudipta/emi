<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateLoanDetailsTable extends Migration
{
public function up()
{
Schema::create('loan_details', function (Blueprint $table) {
$table->id();
$table->integer('clientid')->index();
$table->integer('num_of_payment');
$table->date('first_payment_date');
$table->date('last_payment_date');
$table->decimal('loan_amount', 14, 2);
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('loan_details');
}
}