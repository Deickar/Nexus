# Documentación del Modelo User

## Descripción General

El modelo `User` representa a un usuario registrado en el Sistema de Autenticación Nexus. Este modelo gestiona toda la información relacionada con los usuarios, incluyendo autenticación, autorización y datos personales.

**Versión de Laravel**: 12.39.0  
**Versión de Sanctum**: 4.2.0  
**Fecha de creación**: 19 de Noviembre de 2025

## Ubicación

```
app/Models/User.php
```

## Herencia

```php
User extends Authenticatable
```

El modelo hereda de `Illuminate\Foundation\Auth\User as Authenticatable`, que proporciona funcionalidades de autenticación de Laravel.

## Traits Utilizados

### 1. HasFactory

**Propósito**: Permite crear instancias de usuarios de prueba usando factories.

**Uso**:
```php
// Crear un usuario de prueba
$user = User::factory()->create();

// Crear múltiples usuarios
$users = User::factory()->count(10)->create();

// Crear usuario con datos específicos
$user = User::factory()->create([
    'email' => 'test@example.com',
]);
```

### 2. Notifiable

**Propósito**: Permite enviar notificaciones al usuario (email, SMS, etc.).

**Uso**:
```php
// Enviar notificación
$user->notify(new WelcomeNotification());

// Enviar notificación por email
$user->notify(new PasswordResetNotification($token));
```

### 3. HasApiTokens (Laravel Sanctum)

**Propósito**: Integración con Laravel Sanctum para autenticación basada en tokens API.

**Métodos proporcionados**:
- `createToken(string $name, array $abilities = [])`: Crea un nuevo token
- `tokens()`: Relación con todos los tokens del usuario
- `currentAccessToken()`: Obtiene el token actual de la petición

**Uso**:
```php
// Crear token de autenticación
$token = $user->createToken('auth-token');
$plainTextToken = $token->plainTextToken; // Token sin hashear para enviar al cliente

// Obtener todos los tokens del usuario
$tokens = $user->tokens;

// Eliminar todos los tokens (logout de todos los dispositivos)
$user->tokens()->delete();

// Eliminar token actual (logout del dispositivo actual)
$user->currentAccessToken()->delete();
```

## Propiedades del Modelo

### Atributos de Base de Datos

| Propiedad          | Tipo                  | Descripción                                    |
|--------------------|-----------------------|------------------------------------------------|
| id                 | int                   | ID único del usuario (auto-incremental)        |
| name               | string                | Nombre completo del usuario (2-255 caracteres) |
| email              | string                | Email único para login (máximo 255 caracteres) |
| password           | string                | Contraseña hasheada con bcrypt                 |
| email_verified_at  | Carbon\|null          | Fecha de verificación de email (opcional)      |
| remember_token     | string\|null          | Token para recordar sesión (opcional)          |
| created_at         | Carbon\|null          | Fecha de creación del registro                 |
| updated_at         | Carbon\|null          | Fecha de última actualización                  |

### Atributos Fillable (Asignables en Masa)

```php
protected $fillable = [
    'name',
    'email',
    'password',
];
```

**Propósito**: Define qué campos pueden ser asignados masivamente mediante `create()` o `fill()`.

**Ejemplo de uso**:
```php
// Crear usuario con asignación masiva
$user = User::create([
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'password' => 'password123', // Se hashea automáticamente
]);

// Actualizar usuario con asignación masiva
$user->fill([
    'name' => 'Juan Carlos Pérez',
    'email' => 'juancarlos@example.com',
]);
$user->save();
```

**Seguridad**: Solo los campos en `$fillable` pueden ser asignados masivamente. Esto previene vulnerabilidades de asignación masiva.

### Atributos Hidden (Ocultos)

```php
protected $hidden = [
    'password',
    'remember_token',
];
```

**Propósito**: Define qué campos se excluyen automáticamente al serializar el modelo a JSON o array.

**Ejemplo**:
```php
$user = User::find(1);

// Al convertir a JSON, password y remember_token se excluyen automáticamente
return response()->json([
    'user' => $user // password y remember_token NO se incluyen
]);

// Resultado:
// {
//     "user": {
//         "id": 1,
//         "name": "Juan Pérez",
//         "email": "juan@example.com",
//         "created_at": "2025-11-19T18:30:00.000000Z",
//         "updated_at": "2025-11-19T18:30:00.000000Z"
//     }
// }
```

### Casts (Conversiones de Tipo)

```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

**Propósito**: Define cómo ciertos atributos deben ser convertidos automáticamente.

#### email_verified_at → datetime

Convierte el campo a un objeto `Carbon\Carbon` (extensión de DateTime).

```php
$user = User::find(1);

// Acceder como objeto Carbon
echo $user->email_verified_at->format('d/m/Y'); // 19/11/2025
echo $user->email_verified_at->diffForHumans(); // hace 2 horas

// Comparar fechas
if ($user->email_verified_at->isToday()) {
    echo "Email verificado hoy";
}
```

#### password → hashed (Novedad de Laravel 12)

**Hashea automáticamente la contraseña con bcrypt al asignarla.**

Esta es una característica nueva de Laravel 12 que simplifica el manejo de contraseñas.

```php
// Laravel 12: La contraseña se hashea automáticamente
$user = new User();
$user->password = 'password123'; // Se hashea automáticamente con bcrypt
$user->save();

// NO es necesario hacer esto (aunque sigue funcionando):
// $user->password = Hash::make('password123'); // ❌ Redundante en Laravel 12

// Verificar contraseña
if (Hash::check('password123', $user->password)) {
    echo "Contraseña correcta";
}
```

**Ventajas del cast 'hashed' en Laravel 12**:
- ✅ Menos código
- ✅ Menos errores (no olvidar hashear)
- ✅ Más consistente
- ✅ Automático y transparente

## Relaciones

### tokens() - Relación con Personal Access Tokens

**Tipo**: MorphMany (Relación polimórfica uno a muchos)

**Descripción**: Un usuario puede tener múltiples tokens de autenticación (diferentes dispositivos, sesiones, etc.).

**Proporcionado por**: Trait `HasApiTokens` de Laravel Sanctum

**Uso**:
```php
$user = User::find(1);

// Obtener todos los tokens del usuario
$tokens = $user->tokens;

// Crear nuevo token
$token = $user->createToken('mobile-app');
$plainTextToken = $token->plainTextToken;

// Eliminar todos los tokens (logout de todos los dispositivos)
$user->tokens()->delete();

// Eliminar tokens específicos
$user->tokens()->where('name', 'mobile-app')->delete();

// Obtener token actual en una petición autenticada
$currentToken = $user->currentAccessToken();
```

## Métodos Principales

### Métodos de Eloquent (Heredados)

#### create(array $attributes)

Crea y guarda un nuevo usuario en la base de datos.

```php
$user = User::create([
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'password' => 'password123', // Se hashea automáticamente
]);
```

#### find($id)

Busca un usuario por su ID.

```php
$user = User::find(1);

if ($user) {
    echo $user->name;
}
```

#### where($column, $value)

Busca usuarios que cumplan una condición.

```php
// Buscar por email
$user = User::where('email', 'juan@example.com')->first();

// Buscar múltiples usuarios
$users = User::where('created_at', '>', now()->subDays(7))->get();
```

#### update(array $attributes)

Actualiza un usuario existente.

```php
$user = User::find(1);
$user->update([
    'name' => 'Juan Carlos Pérez',
]);
```

#### delete()

Elimina un usuario de la base de datos.

```php
$user = User::find(1);
$user->delete();
```

### Métodos de Sanctum (Proporcionados por HasApiTokens)

#### createToken(string $name, array $abilities = [])

Crea un nuevo token de autenticación para el usuario.

```php
$user = User::find(1);

// Crear token simple
$token = $user->createToken('auth-token');
$plainTextToken = $token->plainTextToken; // Token para enviar al cliente

// Crear token con permisos específicos
$token = $user->createToken('admin-token', ['admin:read', 'admin:write']);
```

**Retorna**: `Laravel\Sanctum\NewAccessToken`

**Propiedades del token**:
- `accessToken`: Modelo del token (PersonalAccessToken)
- `plainTextToken`: Token en texto plano (solo disponible al crear)

#### tokens()

Obtiene todos los tokens del usuario.

```php
$user = User::find(1);

// Obtener todos los tokens
$tokens = $user->tokens;

// Contar tokens activos
$count = $user->tokens()->count();

// Eliminar todos los tokens
$user->tokens()->delete();
```

#### currentAccessToken()

Obtiene el token actual usado en la petición autenticada.

```php
// En un controlador con usuario autenticado
$token = $request->user()->currentAccessToken();

// Obtener información del token
echo $token->name; // Nombre del token
echo $token->created_at; // Fecha de creación

// Eliminar token actual (logout)
$request->user()->currentAccessToken()->delete();
```

## Ejemplos de Uso Completos

### Registro de Usuario

```php
use App\Models\User;

// Crear nuevo usuario (Laravel 12 hashea automáticamente)
$user = User::create([
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'password' => 'password123', // Se hashea automáticamente
]);

// Generar token de autenticación
$token = $user->createToken('auth-token')->plainTextToken;

// Retornar respuesta
return response()->json([
    'user' => $user, // password y remember_token se excluyen automáticamente
    'token' => $token,
], 201);
```

### Login de Usuario

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Buscar usuario por email
$user = User::where('email', $request->email)->first();

// Verificar contraseña
if (!$user || !Hash::check($request->password, $user->password)) {
    return response()->json([
        'message' => 'Credenciales incorrectas'
    ], 401);
}

// Generar token
$token = $user->createToken('auth-token')->plainTextToken;

return response()->json([
    'user' => $user,
    'token' => $token,
]);
```

### Logout de Usuario

```php
// Eliminar token actual (logout del dispositivo actual)
$request->user()->currentAccessToken()->delete();

return response()->json([
    'message' => 'Sesión cerrada exitosamente'
]);
```

### Logout de Todos los Dispositivos

```php
// Eliminar todos los tokens del usuario
$request->user()->tokens()->delete();

return response()->json([
    'message' => 'Sesión cerrada en todos los dispositivos'
]);
```

### Actualizar Perfil de Usuario

```php
$user = $request->user();

$user->update([
    'name' => $request->name,
    'email' => $request->email,
]);

return response()->json([
    'user' => $user,
    'message' => 'Perfil actualizado exitosamente'
]);
```

### Cambiar Contraseña

```php
$user = $request->user();

// Verificar contraseña actual
if (!Hash::check($request->current_password, $user->password)) {
    return response()->json([
        'message' => 'Contraseña actual incorrecta'
    ], 400);
}

// Actualizar contraseña (se hashea automáticamente en Laravel 12)
$user->password = $request->new_password;
$user->save();

// Opcional: Cerrar sesión en otros dispositivos
$user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete();

return response()->json([
    'message' => 'Contraseña actualizada exitosamente'
]);
```

## Validaciones Recomendadas

### Al Crear Usuario

```php
$request->validate([
    'name' => 'required|string|min:2|max:255',
    'email' => 'required|email|unique:users,email|max:255',
    'password' => 'required|string|min:8|confirmed',
]);
```

### Al Actualizar Usuario

```php
$request->validate([
    'name' => 'sometimes|required|string|min:2|max:255',
    'email' => 'sometimes|required|email|unique:users,email,' . $user->id . '|max:255',
]);
```

### Al Cambiar Contraseña

```php
$request->validate([
    'current_password' => 'required|string',
    'new_password' => 'required|string|min:8|confirmed',
]);
```

## Seguridad

### Contraseñas

- ✅ Las contraseñas se hashean automáticamente con bcrypt (cast 'hashed' en Laravel 12)
- ✅ Las contraseñas nunca se exponen en respuestas JSON (hidden)
- ✅ Usar `Hash::check()` para verificar contraseñas

### Tokens

- ✅ Los tokens se almacenan hasheados en la base de datos
- ✅ El token en texto plano solo está disponible al crearlo
- ✅ Los tokens pueden tener fecha de expiración
- ✅ Los tokens se pueden revocar individualmente o en masa

### Asignación Masiva

- ✅ Solo los campos en `$fillable` pueden ser asignados masivamente
- ✅ Esto previene vulnerabilidades de asignación masiva
- ✅ Nunca agregar campos sensibles a `$fillable`

## Mejores Prácticas

1. **Usar el cast 'hashed' para contraseñas (Laravel 12)**
   ```php
   'password' => 'hashed'
   ```

2. **Ocultar campos sensibles**
   ```php
   protected $hidden = ['password', 'remember_token'];
   ```

3. **Validar datos antes de crear/actualizar**
   ```php
   $request->validate([...]);
   ```

4. **Usar tokens con nombres descriptivos**
   ```php
   $user->createToken('mobile-app');
   $user->createToken('web-session');
   ```

5. **Revocar tokens al cambiar contraseña**
   ```php
   $user->tokens()->delete();
   ```

6. **Usar relaciones de Eloquent**
   ```php
   $user->tokens()->where('name', 'mobile-app')->delete();
   ```

## Testing

### Crear Usuario de Prueba

```php
use App\Models\User;

// En tests
$user = User::factory()->create([
    'email' => 'test@example.com',
]);
```

### Autenticar Usuario en Tests

```php
use Laravel\Sanctum\Sanctum;

// Autenticar usuario para el test
Sanctum::actingAs($user);

// Hacer petición autenticada
$response = $this->postJson('/api/logout');
```

## Novedades de Laravel 12

### Cast 'hashed' Automático

Laravel 12 introduce el cast 'hashed' que hashea automáticamente las contraseñas:

```php
// Antes (Laravel 11 y anteriores)
$user->password = Hash::make($request->password);

// Ahora (Laravel 12)
$user->password = $request->password; // Se hashea automáticamente
```

### Ventajas

- ✅ Código más limpio y simple
- ✅ Menos posibilidad de errores
- ✅ Consistencia automática
- ✅ Mejor experiencia de desarrollo

---

**Última actualización**: 19 de Noviembre de 2025  
**Versión de Laravel**: 12.39.0  
**Versión de Sanctum**: 4.2.0
