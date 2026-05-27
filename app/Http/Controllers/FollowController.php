<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notificacion;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        if (auth()->id() == $user->id) {
            return back();
        }

        $authUser = auth()->user();

        $existe = $authUser->siguiendo()
            ->where('us_sig', $user->id)
            ->exists();

        if ($existe) {

            $authUser->siguiendo()
                ->detach($user->id);

        } else {

            $authUser->siguiendo()
                ->attach($user->id);

            // 🔔 NOTIFICACIÓN
            Notificacion::create([

                'tit_not' => 'Nuevo seguidor',

                'men_not' => auth()->user()->nom_us .
                    ' comenzó a seguirte',

                'tip_not' => 'seguidor',

                'lei_not' => false,

                'usuario_id' => $user->id,

                'url_not' => route(
                    'usuario.profile',
                    auth()->user()
                ),
            ]);
        }

        return back();
    }
}