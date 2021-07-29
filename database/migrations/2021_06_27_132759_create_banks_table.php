<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('banks')->insert($this->bankList());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }

    /**
     * Retrieve the list of banks.
     *
     * @return array
     */
    protected function bankList(): array
    {
        $now = now()->toDateTimeString();

        return [
            ['name' => 'Access Bank', 'code' => '044', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Access Bank (Diamond)', 'code' => '063', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ALAT by WEMA', 'code' => '035A', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ASO Savings and Loans', 'code' => '401', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bowen Microfinance Bank', 'code' => '50931', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'CEMCS Microfinance Bank', 'code' => '50823', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Citibank Nigeria', 'code' => '023', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ecobank Nigeria', 'code' => '050', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ekondo Microfinance Bank', 'code' => '562', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fidelity Bank', 'code' => '070', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'First Bank of Nigeria', 'code' => '011', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'First City Monument Bank', 'code' => '214', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'FSDH Merchant Bank Limited', 'code' => '501', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Globus Bank', 'code' => '00103', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Guaranty Trust Bank', 'code' => '058', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Hackman Microfinance Bank', 'code' => '51251', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Hasal Microfinance Bank', 'code' => '50383', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Heritage Bank', 'code' => '030', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Jaiz Bank', 'code' => '301', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Keystone Bank', 'code' => '082', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kuda Bank', 'code' => '50211', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'One Finance', 'code' => '565', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Parallex Bank', 'code' => '526', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Polaris Bank', 'code' => '076', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Providus Bank', 'code' => '101', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Rubies MFB', 'code' => '125', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sparkle Microfinance Bank', 'code' => '51310', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Stanbic IBTC Bank', 'code' => '221', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Standard Chartered Bank', 'code' => '068', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sterling Bank', 'code' => '232', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Suntrust Bank', 'code' => '100', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'TAJ Bank', 'code' => '302', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Titan Bank', 'code' => '102', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Union Bank of Nigeria', 'code' => '032', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'United Bank For Africa', 'code' => '033', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Unity Bank', 'code' => '215', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Wema Bank', 'code' => '035', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Zenith Bank', 'code' => '057', 'created_at' => $now, 'updated_at' => $now],
        ];
    }
}
