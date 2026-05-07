<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class CantidadRule implements DataAwareRule, ValidationRule
{
    protected $data = [];

    protected $isUpdate = false;
    protected $currentId = null;

    public function __construct($isUpdate = false, $currentId = null)
    {
        $this->isUpdate = $isUpdate;
        $this->currentId = $currentId;
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

        $hotel = DB::table('hoteles')->where('id', '=', $this->data["hotel_id"])->get();
        $result = DB::table('habitaciones')->selectRaw('sum(cantidad) as cantidad_ocupada')
            ->where('hotel_id', '=', $this->data['hotel_id'])->get();

        $total = $result[0]->cantidad_ocupada + $this->data["cantidad"];

        if ($total > $hotel[0]->numero_habitaciones) {
            $fail("The total rooms ({$total}) exceeds the hotel's capacity of {$hotel[0]->numero_habitaciones} rooms.");
        }
    }
}
