<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ValidPassword implements Rule
{
    /**
     * Determine if the Length Validation Rule passes.
     *
     * @var bool
     */
    public bool $lengthPasses = true;

    /**
     * Determine if the Uppercase Validation Rule passes.
     *
     * @var bool
     */
    public bool $upperCasePasses = true;

    /**
     * Determine if the Numeric Validation Rule passes.
     *
     * @var bool
     */
    public bool $numericPasses = true;

    /**
     * Determine if the Special Character Validation Rule passes.
     *
     * @var bool
     */
    public bool $specialCharacterPasses = true;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->upperCasePasses = (Str::lower($value) !== $value);
        $this->numericPasses = ((bool) preg_match('/[0-9]/', $value));
        $this->specialCharacterPasses = ((bool) preg_match('/[^A-Za-z0-9]/', $value));

        return $this->lengthPasses && $this->upperCasePasses && $this->numericPasses && $this->specialCharacterPasses;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        switch (true) {

            case ! $this->upperCasePasses
                && $this->numericPasses
                && $this->specialCharacterPasses:

                return 'The :attribute must have least one uppercase character.';

            case ! $this->numericPasses
                && $this->upperCasePasses
                && $this->specialCharacterPasses:

                return 'The :attribute must contain at least one number.';

            case ! $this->specialCharacterPasses
                && $this->upperCasePasses
                && $this->numericPasses:

                return 'The :attribute must contain at least one special character.';

            case ! $this->upperCasePasses
                && ! $this->numericPasses
                && $this->specialCharacterPasses:

                return 'The :attribute must contain at least one uppercase character and one number.';

            case ! $this->upperCasePasses
                && ! $this->specialCharacterPasses
                && $this->numericPasses:

                return 'The :attribute must contain at least one uppercase character and one special character.';

            case ! $this->upperCasePasses
                && ! $this->numericPasses
                && ! $this->specialCharacterPasses:

                return 'The :attribute must be at least 8 characters and contain at least one uppercase character, one number, and one special character.';

            default:
                return 'The :attribute must be at least 8 characters.';
        }
    }
}
