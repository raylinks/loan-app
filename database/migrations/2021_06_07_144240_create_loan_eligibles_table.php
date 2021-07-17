<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanEligiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_eligibles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->float('range_from', 8, 2);
            $table->float('range_to', 8, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
        $this->seedData();
    }

    private function seedData()
    {
        DB::table('loan_eligibles')->insert([
            [
                'name' => 'level one',
                'slug' => 'level_one',
                'range_from' => 1000.00,
                'range_to' => 5000.00,
                'amount' => '5000.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level two',
                'slug' => 'level_two',
                'range_from' => 5000.00,
                'range_to' => 10000.00,
                'amount' => 10000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level three',
                'slug' => 'level_three',
                'range_from' => 10000.00,
                'range_to' => 20000.00,
                'amount' => 20000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level four',
                'slug' => 'level_four',
                'range_from' => 20000.00,
                'range_to' => 50000.00,
                'amount' => 50000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_eligibilities');
    }
}
