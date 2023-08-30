<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';

    protected $fillable = ['student_id', 'name', 'email', 'phone', 'code'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'code');
    }
}
