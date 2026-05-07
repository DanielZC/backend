<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table('habitaciones', key: 'id')]
#[Fillable(['hotel_id', 'cantidad', 'tipo_habitacion', 'acomodacion'])]
class HabitacionModel extends Model
{
    //
}
