<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class UsuarioService
{
    /**
     * Lista usuarios aplicando filtros y paginación.
     *
     * @param array $filtros
     * @param int $perPage
     * @return LengthAwarePaginator
     */
   public function listarUsuarios(array $filtros = [], int $perPage = 15): LengthAwarePaginator
{
    $query = User::query();

    // Comprobar si la clave 'rol' existe en el array y tiene valor válido.
    // Usamos array_key_exists para distinguir entre "no existe" y valor '0'.
    if (array_key_exists('rol', $filtros) && $filtros['rol'] !== null && $filtros['rol'] !== '') {
        $rol = (int) $filtros['rol'];
        $query->where('id_rol', $rol);
    }

    $query->orderBy('fecha_creacion', 'desc');

    return $query->paginate($perPage);
}

    /**
     * Obtener un usuario por su id (lanza ModelNotFoundException si no existe).
     *
     * @param mixed $id
     * @return User
     */
    public function obtenerUsuario($id): User
    {
        // Si tu PK se llama id_usuario, asegúrate que el modelo lo tenga configurado
        return User::findOrFail($id);
    }

    /**
     * Crear usuario (usa transaction).
     *
     * @param array $datos
     * @return User
     */
    public function crearUsuario(array $datos): User
    {
        return DB::transaction(function () use ($datos) {
            // Sanitizar y mapear datos si es necesario
            if (isset($datos['contrasena'])) {
                $datos['contrasena'] = Hash::make($datos['contrasena']);
            }

            // Asegúrate de que $fillable en el modelo permita estos campos
            return User::create($datos);
        });
    }

    /**
     * Actualizar usuario.
     *
     * @param mixed $id
     * @param array $datos
     * @return User
     */
    public function actualizarUsuario($id, array $datos): User
    {
        return DB::transaction(function () use ($id, $datos) {
            $usuario = User::findOrFail($id);

            $datosActualizar = collect($datos)->except('contrasena')->toArray();

            if (!empty($datos['contrasena'])) {
                $datosActualizar['contrasena'] = Hash::make($datos['contrasena']);
            }

            $usuario->update($datosActualizar);

            return $usuario->refresh();
        });
    }

    /**
     * Eliminar usuario (no permite eliminar al usuario actual).
     *
     * @param mixed $id
     * @param mixed|null $idUsuarioActual
     * @return bool
     * @throws \Exception
     */
    public function eliminarUsuario($id, $idUsuarioActual = null): bool
    {
        if ($id == $idUsuarioActual) {
            throw new \Exception('No puedes eliminar tu propio usuario');
        }

        return DB::transaction(function () use ($id) {
            $usuario = User::findOrFail($id);
            $usuario->delete();
            return true;
        });
    }
}
