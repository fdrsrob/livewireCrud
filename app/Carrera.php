<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Students;

class Carrera extends Model
{
    protected $table = 'careers';

    protected $fillable = ['racer_name', 'description'];

    public function students()
    {
        return $this->hasMany(Students::class, 'id','id');
    }
}
