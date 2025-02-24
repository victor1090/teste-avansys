<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operadora extends Model
{
    use HasFactory;

    protected $table = 'operadoras';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'descricao',
        'status'
    ];
}
