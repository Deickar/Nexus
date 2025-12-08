<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ViewLoadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider vistasPublicas
     */
    // Pruebas de vistas publicas.
    #[DataProvider('vistasPublicas')]
    public function test_de_carga_vista_correcta($uri): void
    {
        // Ejecuta la peticion GET de la ruta
        $this->get($uri)
            // Afirma que el codigo estatus 200 que signifca OK
            ->assertStatus(200);
    }

    public static function vistasPublicas(): array
    {
        return [
            // Vistas de Auth
            'Login Page' => ['/login'],
            'Register Page' => ['/register'],
            // Vistas de nivel superior
            'Home Page' => ['/'],
            'Contact Page' => ['/contacto'],
            'Offers Page' => ['/ofertas'],
            'Categoris Page' => ['/categorias'],
            'Category Detail' => ['/categorias/slug-ejemplo'], // ajusta la ruta dinamica
        ];
    }

    /**
     * @dataProvider vistasAutenticadas
     */
    // Prueba de vista de autenticadas (ACCOUNT)
    #[DataProvider('vistasAutenticadas')]
    public function test_carga_de_vista_autenticadas_correcta($uri): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get($uri)
            ->assertStatus(200);
    }

    public static function vistasAutenticadas(): array
    {
        return [
            // Vistas de Account
            'Profile Page' => ['/mi-cuenta/perfil'],
            'Favorite Page' => ['/mi-cuenta/favoritos'],
            'Orders Page' => ['/mi-cuenta/ordenes'],
            'Reviews Page' => ['/mi-cuenta/resenas'],
            'Address Page' => ['/mi-cuenta/direccion'],
        ];
    }

    /**
     * @dataProvider vistasAdmin
     */
    // Pruebas de vistas de administrador (ADMIN)
    #[DataProvider('vistasAdmin')]
    public function test_carga_de_vista_admin($uri): void
    {
        Http::fake([
            // Mock para /admin/productos (AÑADIMOS LA CLAVE 'description')
            '*/admin/productos' => Http::response([
                [
                    'id' => 1,
                    'name' => 'Mock Product 1',
                    'image' => '/img/mock-product-1.jpg',
                    'price' => 10.99,
                    'description' => 'A short description for testing.', //  ¡NUEVA CLAVE AÑADIDA!
                    // Si la vista usa más campos (ej. 'stock', 'slug', 'category_name'), ¡añádelos aquí!
                ],
                [
                    'id' => 2,
                    'name' => 'Mock Product 2',
                    'image' => '/img/mock-product-2.jpg',
                    'price' => 20.99,
                    'description' => 'Another description for testing.', //  ¡NUEVA CLAVE AÑADIDA!
                ],
            ], 200),

            // Mock para /admin/dashboard (Se mantiene igual)
            '*/admin/dashboard' => Http::response([
                'users_count' => 10,
                'latest_orders' => [],
                'recent_logins' => [],
            ], 200),

            '*' => Http::response('OK', 200),
        ]);
        /** @var User $admin */
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get($uri)
            ->assertStatus(200); // podria 302 tambien si es dashboard
    }

    public static function vistasAdmin(): array
    {
        return [
            'Admin Index' => ['/admin'],
            'Admin Profile' => ['/admin/profile'],
        ];
    }
}
