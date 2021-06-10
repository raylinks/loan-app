<?php

namespace App\Traits;

use Propaganistas\LaravelPhone\PhoneNumber;

trait HasBvnProviderResponse
{
    public string $firstName;

    public string $lastName;

    public ?string $email;

    public ?string $dateOfBirth;

    public string $phone;

    public string $enrollmentBank;

    public string $enrollmentBankBranch;

    public string $unformattedPhoneNumber;

    public function flutterWave($verifyBvn)
    {
        $this->firstName = ucfirst(strtolower(trim($verifyBvn['data']['first_name'])));
        $this->lastName = ucfirst(strtolower(trim($verifyBvn['data']['last_name'])));
        $this->email = validator(['email' => $verifyBvn['data']['email']], ['email' => 'string|email'])->passes() ? $verifyBvn['data']['email'] : null;
        $this->dateOfBirth = $verifyBvn['data']['date_of_birth'] ?? null;
        //$this->phone = substr_replace(($verifyBvn['data']['phone_number']) ? PhoneNumber::make($verifyBvn['data']['phone_number'], 'NG') : '', ' + 234', 0, 1);
        $this->enrollmentBank = trim($verifyBvn['data']['enrollment_bank']);
        $this->enrollmentBankBranch = trim($verifyBvn['data']['enrollment_branch']);

        return $this;
    }
}
