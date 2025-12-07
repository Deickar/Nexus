<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewLoadTest extends TestCase{

    use RefreshDatabase; 
    /**
     * @dataProvider vistasPublicas
     */
    // Pruebas de vistas publicas.
    public function test_de_carga_vista_correcta($uri):void{
        // Ejecuta la peticion GET de la ruta
     $this -> get($uri)
        //Afirma que el codigo estatus 200 que signifca OK
         ->assertStatus(200);
    
    }
    public static function vistasPublicas():array{
        return[
            // Vistas de Auth
            'Login Page' =>['/login'],
            'Resgister Page' => ['/register'],
            //Vistas de nivel superior
            'Home Page' => ['/'],
            'Contact Page' => ['/contact'],
            'Offers Page' => ['/offers'],
            'Categoris Page'=> ['/categories'],
            'Category Detail' => ['/category/slug-ejemplo']// ajusta la ruta dinamica 
        ];

    }
    /**
     * @dataProvider vistasAutenticadas
     */
    // Prueba de vista de autenticadas (ACCOUNT)
    public function test_carga_de_VistaAutenticadas_correcta($uri):void{

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user) 
         ->get($uri)
         ->assertStatus(200);
    }

    public static function vistasAutenticadas():array{
        return[
            //Vistas de Account
            'Profile Page' =>['/account/profile'],
            'Favorite Page' => ['/account/favorites'],
            'Orders Page' => ['/account/order'],
            'Reviews Page' => ['/account/reviews'],
            'Address Page' => ['/account/address']
        ];
    }
    /** 
    * @dataProvider vistasAdmin
    */
    //Pruebas de vistas de administrador (ADMIN)
    public function test_carga_de_VistaAdmin($uri):void{
        
        /** @var User $admin */
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get($uri)
            ->assertStatus(200); // podria 302 tambien si es dashboard
    }

    public static function vistasAdmin():array{
        return[
            'Admin Index' =>['/admin'],
            'Admin Profile' => ['/admin/profile']
        ];
    }
}






