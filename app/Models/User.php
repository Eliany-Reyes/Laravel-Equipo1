<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * El nombre de la tabla de la base de datos.
     * @var string
     */
    protected $table = 'Usuarios';

    /**
     * La clave primaria de la tabla.
     * @var string
     */
    protected $primaryKey = 'cod_usuario';

    /**
     * Los atributos que son asignables masivamente.
     * @var array<int, string>
     */
    protected $fillable = [
        'cod_persona',
        'nombre_usuario',
        'correo_electronico',
        'contrasena',
        'id_rol',
        'estado',
        'fecha_registro',
        'ultimo_acceso',
        'contrasena_plana', // <-- Aquí se agrega la nueva columna
    ];

    /**
     * Se ocultará el campo 'contrasena' por seguridad.
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    /**
     * Sobreescribe este método para decirle a Laravel que el campo de la contraseña
     * en la base de datos se llama 'contrasena' y no 'password'.
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}