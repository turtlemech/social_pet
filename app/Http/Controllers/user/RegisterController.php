<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('user.register');
    }

    /**
     * Procesa el registro de un nuevo usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'nom_us' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'app_us' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apm_us' => 'nullable|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/',
            'ema_us' => 'required|string|email|max:255|unique:usuarios,ema_us',
            'pas_us' => 'required|string|min:6|confirmed',
            'tel_us' => 'nullable|string|max:20|regex:/^[0-9+\-\s]+$/',
            'ubi_us' => 'nullable|string|max:255',
            'terms' => 'accepted'
        ], [
            // Mensajes de error personalizados
            'nom_us.required' => 'El nombre es obligatorio',
            'nom_us.regex' => 'El nombre solo puede contener letras',
            'app_us.required' => 'El apellido paterno es obligatorio',
            'app_us.regex' => 'El apellido solo puede contener letras',
            'apm_us.regex' => 'El apellido solo puede contener letras',
            'ema_us.required' => 'El correo electrónico es obligatorio',
            'ema_us.email' => 'Ingresa un correo electrónico válido',
            'ema_us.unique' => 'Este correo electrónico ya está registrado',
            'pas_us.required' => 'La contraseña es obligatoria',
            'pas_us.min' => 'La contraseña debe tener al menos 6 caracteres',
            'pas_us.confirmed' => 'Las contraseñas no coinciden',
            'tel_us.regex' => 'El teléfono solo puede contener números, +, - y espacios',
            'terms.accepted' => 'Debes aceptar los términos y condiciones'
        ]);

        // Si la validación falla, regresar con errores
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generar código de usuario con formato USR000
            $cod_us = $this->generateUserCode();
            
            // Crear el nuevo usuario
            $user = User::create([
                'cod_us' => $cod_us,
                'nom_us' => $request->nom_us,
                'app_us' => $request->app_us,
                'apm_us' => $request->apm_us,
                'ema_us' => $request->ema_us,
                'pas_us' => Hash::make($request->pas_us),
                'tel_us' => $request->tel_us,
                'ubi_us' => $request->ubi_us,
                'ava_us' => null, // Avatar por defecto
                'tip_us' => 'usuario', // Tipo de usuario
                'est_us' => 'activo', // Estado activo por defecto
                'is_admin' => false, // No es administrador
            ]);

            // Enviar correo de bienvenida
            $mensajeCorreo = "";
            try {
                // Verificar que la configuración de mail existe
                if (config('mail.default')) {
                    Mail::to($user->ema_us)->send(new WelcomeUserMail($user, $cod_us));
                    $mensajeCorreo = " Te hemos enviado un correo de bienvenida a {$user->ema_us}.";
                    Log::info('Correo de bienvenida enviado exitosamente a: ' . $user->ema_us);
                } else {
                    $mensajeCorreo = " El correo de bienvenida no se pudo enviar por configuración, pero tu registro se completó correctamente.";
                    Log::warning('Configuración de mail no encontrada para enviar correo a: ' . $user->ema_us);
                }
            } catch (\Exception $mailError) {
                // Si falla el envío del correo, registramos el error pero continuamos
                Log::error('Error al enviar correo de bienvenida a ' . $user->ema_us . ': ' . $mailError->getMessage());
                Log::error('Stack trace: ' . $mailError->getTraceAsString());
                $mensajeCorreo = " No pudimos enviar el correo de bienvenida (" . $mailError->getMessage() . "), pero tu registro se completó correctamente. Por favor, contacta a soporte si no recibes el correo.";
            }

            // Redirigir al login con mensaje de éxito
            return redirect()->route('login')
                ->with('success', '¡Registro exitoso ' . $request->nom_us . '! Tu código de usuario es: ' . $cod_us . '.' . $mensajeCorreo . ' Ahora puedes iniciar sesión.');

        } catch (\Exception $e) {
            // Si hay error, regresar con mensaje de error
            Log::error('Error al registrar usuario: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error al registrar usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Genera el siguiente código de usuario con formato USR000
     * Busca el último código USRxxx en la base de datos y crea el siguiente
     * 
     * Ejemplos:
     * - Si no hay usuarios: USR001
     * - Si el último es USR001: USR002
     * - Si el último es USR025: USR026
     * - Si el último es USR099: USR100
     * - Si el último es USR999: USR1000
     *
     * @return string
     */
    private function generateUserCode()
    {
        // Buscar el último usuario con código que empiece por 'USR'
        $lastUser = User::where('cod_us', 'LIKE', 'USR%')
            ->orderBy('cod_us', 'desc')
            ->first();
        
        if ($lastUser && $lastUser->cod_us) {
            // Extraer el número del código (ej: USR025 -> 025)
            // Usamos substr para obtener los caracteres después de 'USR'
            $numberPart = substr($lastUser->cod_us, 3);
            
            // Convertir a entero (elimina ceros a la izquierda automáticamente)
            $lastNumber = intval($numberPart);
            
            // Incrementar el número
            $newNumber = $lastNumber + 1;
            
            // Determinar el ancho del padding
            // Mantiene al menos 3 dígitos, pero se expande si el número es mayor
            $padding = max(3, strlen((string)$newNumber));
            
            // Formatear el nuevo código con ceros a la izquierda
            // Ejemplo: 1 -> 001, 25 -> 025, 100 -> 100, 1000 -> 1000
            $cod_us = 'USR' . str_pad($newNumber, $padding, '0', STR_PAD_LEFT);
        } else {
            // Si no hay ningún usuario con código USR, empezar con USR001
            $cod_us = 'USR001';
        }
        
        return $cod_us;
    }

    /**
     * Método opcional para verificar la generación de códigos (solo para pruebas)
     * Puedes acceder a /test-code-generation para probar
     *
     * @return void
     */
    public function testCodeGeneration()
    {
        if (app()->environment('local')) {
            $testCodes = [];
            for ($i = 1; $i <= 10; $i++) {
                $testCodes[] = $this->generateUserCode();
            }
            dd($testCodes);
        }
        
        abort(404);
    }
}