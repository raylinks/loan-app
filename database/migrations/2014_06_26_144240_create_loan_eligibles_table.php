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
                'range_from' => 100.00,
                'range_to' => 999.00,
                'amount' => '10.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level two',
                'slug' => 'level_two',
                'range_from' => 1000.00,
                'range_to' => 2000.00,
                'amount' => '20.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level three',
                'slug' => 'level_three',
                'range_from' => 1000.00,
                'range_to' => 2000.00,
                'amount' => '20.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level four',
                'slug' => 'level_four',
                'range_from' => 1000.00,
                'range_to' => 2000.00,
                'amount' => '20.00',
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
