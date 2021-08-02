<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraAmountFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->decimal('amount_borrowed')->default(0.00)->after('id');
            $table->string('reason')->after('id');
            $table->decimal('amount_to_be_paid', 15, 2)->default(0.00)->after('id');
            $table->timestamp('approved_at')->nullable();
            $table->dropColumn(['amount']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->dropColumn(['amount_borrowed', 'reason', 'amount_to_be_paid']);
            $table->string('amount')->after('id');
        });
    }
}
