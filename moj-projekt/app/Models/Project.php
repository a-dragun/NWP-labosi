<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'naziv_projekta',
        'opis_projekta',
        'cijena_projekta',
        'obavljeni_poslovi',
        'datum_pocetka',
        'datum_zavrsetka',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}
