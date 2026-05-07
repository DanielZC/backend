<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('hoteles', key: 'id')]
#[Fillable(['ciudad', 'nombre', 'nit', 'direccion', 'numero_habitaciones'])]
class HotelModel extends Model
{
    //
}
