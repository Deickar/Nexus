<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Nombre de la tabla en la base de datos
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'id_usuario';

    // Si la PK es autoincremental y es int (ajusta si no es el caso)
    public $incrementing = true;

    protected $keyType = 'int';

    // Nombres de las columnas de timestamps (Laravel los usará automáticamente)
    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = 'fecha_actualizacion';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_completo',
        'correo_electronico',
        'contrasena',
        'telefono',
        'direccion',
        'id_rol',
    ];

    // Campos ocultos en JSON
    protected $hidden = [
        'contrasena',
    ];

    // Casts de atributos (fechas y otros)
    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Mutator: al asignar 'contrasena' la guardamos hasheada.
     * Evita que olvides hashear la contraseña en el servicio/controlador.
     */
    public function setContrasenaAttribute($value)
    {
        if (! is_null($value) && $value !== '') {
            // Si ya está hasheada (por alguna razón), no volver a hashear:
            if (Hash::needsRehash($value)) {
                $this->attributes['contrasena'] = Hash::make($value);
            } else {
                $this->attributes['contrasena'] = $value;
            }
        }
    }

    /**
     * Definir cuál es el campo que Laravel Auth usa como password.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Si necesitas un accessor para compatibilidad (opcional).
     * Por ejemplo: $user->name devolverá nombre_completo
     */
    public function getNameAttribute()
    {
        return $this->nombre_completo;
    }

    /**
     * Si necesitas crear una representación simplificada en array/json,
     * es mejor usar accessors o Resources, no sobrescribir toArray.
     * Si realmente quieres campos personalizados al serializar,
     * usa un API Resource (Recommended).
     */
}
