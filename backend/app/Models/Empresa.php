<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empreses';

    protected $fillable = [
        'id',
        'nom',
        'foto_nom',
        'CIFF',
        'user_id',
        'descripcio',
        'direcció'
    ];
    public function propietari()
    {
        return $this->belongsTo(User::class, 'user_id'); // Aquí asumo que tienes una columna 'user_id' en la tabla empresas que referencia a 'id' en la tabla users
    }
}
