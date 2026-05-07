<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AcomodacionRule implements DataAwareRule, ValidationRule
{
    protected $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->data["tipo_habitacion"] == "Estándar") {
            if (in_array($this->data["acomodacion"], ["Triple", "Cuádruple"])) {
                $fail("The :attribute must be Sencilla or Doble.");
            }
        }

        if ($this->data["tipo_habitacion"] == "Junior") {
            if (in_array($this->data["acomodacion"], ["Sencilla", "Doble"])) {
                $fail("The :attribute must be Triple or Cuádruple.");
            }
        }

        if ($this->data["tipo_habitacion"] == "Suite") {
            if (in_array($this->data["acomodacion"], ["Cuádruple"])) {
                $fail("The :attribute must be Triple or Cuádruple.");
            }
        }
    }
}
