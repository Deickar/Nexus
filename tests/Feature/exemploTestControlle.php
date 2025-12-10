<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage; // Para simular la subida de archivos
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase; // Usar la DB de prueba para cada test

    /**
     * Prueba el endpoint de actualización de perfil de administrador (updateProfile).
     *
     * @return void
     */
    public function test_admin_profile_can_be_updated_successfully(): void
    {
        // --- 1. PREPARACIÓN (Arrange) ---
        // Crear un usuario administrador en la DB de prueba
        /** @var User $admin */
        $admin = User::factory()->create([
            'is_admin' => true,
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        // 1.1. Simular datos de entrada
        $updatedData = [
            'name' => 'New Admin Name',
            'email' => 'new@example.com',
            // Simular un campo de contraseña y confirmación, aunque no se actualice
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        // 1.2. Simular un archivo (si la lógica del controlador lo permite)
        // Storage::fake('public'); // Descomentar si el controlador maneja archivos

        // --- 2. EJECUCIÓN (Act) ---
        // Actuar como el administrador y enviar la petición POST
        $response = $this->actingAs($admin)->post(
            '/admin/profile/update', // Reemplaza por la ruta real
            $updatedData
        );

        // --- 3. VERIFICACIÓN (Assert) ---

        // 3.1. Afirmar el código HTTP y la redirección
        // El método updateProfile devuelve back()->with(), lo que resulta en un 302
        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Perfil actualizado correctamente controlador admin OK.');

        // 3.2. Afirmar que la base de datos se actualizó (Lógica de negocio simulada)

        // Refrescar el modelo desde la DB para obtener los cambios
        $admin->refresh();

        // **NOTA IMPORTANTE:** El controlador original no implementa la lógica de actualización
        // $admin->refresh() fallará si la lógica no está en el controlador real.
        // Si tu controlador tuviera la lógica (ej. $admin->update($request->validated())),
        // estas afirmaciones serían funcionales.

        // Simulación de aserción si el controlador estuviera completo:
        // $this->assertEquals('New Admin Name', $admin->name);
        // $this->assertEquals('new@example.com', $admin->email);


        // 3.3. Afirmar la presencia de datos en la DB (Verificación de bajo nivel)
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'New Admin Name', // Asegurar que el nombre se guardó
            'email' => 'new@example.com', // Asegurar que el email se guardó
        ]);
    }
}
