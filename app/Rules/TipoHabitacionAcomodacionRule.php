<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class TipoHabitacionAcomodacionRule implements DataAwareRule, ValidationRule
{
    protected $data = [];

    protected $ignoreId = null;

    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

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
        $result = DB::table('habitaciones')
            ->where('hotel_id', '=', $this->data['hotel_id'])
            ->where('tipo_habitacion', '=', $this->data['tipo_habitacion'])
            ->where('acomodacion', '=', $this->data["acomodacion"]);

        if ($this->ignoreId) {
            $result->where('id', '!=', $this->ignoreId);
        }

        $exists = $result->exists();

        if ($exists) {
            $fail("The combination of tipo_habitacion and acomodacion already exists in this hotel.");
        }
    }
}
