<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsSoporteSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['tecnico', 'cuenta', 'mascota', 'pago', 'otro'];
        $prioridades = ['baja', 'media', 'alta', 'urgente'];
        $estados = ['abierto', 'en_proceso', 'resuelto', 'cerrado'];
        
        $asuntos = [
            'tecnico' => ['Error en la app', 'No puedo iniciar sesión', 'La app se cierra sola', 'Problemas con notificaciones'],
            'cuenta' => ['Olvidé mi contraseña', 'Quiero eliminar mi cuenta', 'Problemas con mi perfil', 'Cambio de correo'],
            'mascota' => ['Error al registrar mascota', 'No puedo editar datos', 'Problemas con fotos', 'Datos duplicados'],
            'pago' => ['Problema con suscripción', 'Reembolso solicitado', 'Error en facturación', 'Método de pago rechazado'],
            'otro' => ['Sugerencia para la app', 'Reportar bug', 'Consulta general', 'Solicitud de feature']
        ];
        
        $mensajes = [
            'tecnico' => 'Tengo problemas técnicos con la aplicación, no carga correctamente.',
            'cuenta' => 'Necesito ayuda con mi cuenta de usuario.',
            'mascota' => 'No puedo agregar una nueva mascota a mi perfil.',
            'pago' => 'Tuve un problema con un pago realizado.',
            'otro' => 'Quisiera hacer una consulta sobre el servicio.'
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $categoria = $categorias[array_rand($categorias)];
            $estado = $estados[array_rand($estados)];
            $prioridad = $prioridades[array_rand($prioridades)];
            $cod_us = 'USR' . str_pad(rand(1, 50), 3, '0', STR_PAD_LEFT);
            
            $ticket = [
                'cod_sop' => 'TKT' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'cod_us' => $cod_us,
                'asu_sop' => $asuntos[$categoria][array_rand($asuntos[$categoria])],
                'cat_sop' => $categoria,
                'pri_sop' => $prioridad,
                'men_sop' => $mensajes[$categoria],
                'est_sop' => $estado,
                'res_sop' => ($estado == 'resuelto' || $estado == 'cerrado') ? 'Problema solucionado exitosamente.' : null,
                'cod_admin' => ($estado != 'abierto') ? 'SOP' . str_pad(rand(1, 11), 3, '0', STR_PAD_LEFT) : null,
                'fec_resuelto' => ($estado == 'resuelto' || $estado == 'cerrado') ? now()->subDays(rand(1, 10)) : null,
                'created_at' => now()->subDays(rand(1, 180)),
                'updated_at' => now(),
            ];
            
            DB::table('soporte')->insert($ticket);
        }
    }
}