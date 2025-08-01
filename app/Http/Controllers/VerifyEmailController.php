<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\VerifyEmailResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     *
     * @param Request $request
     * @return VerifyEmailResponse
     */
    public function __invoke(Request $request): VerifyEmailResponse
    {
        // Obtener el usuario por ID
        $user = User::findOrFail($request->route('id'));

        // Verificar que el hash coincida
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        // Verificar que el enlace no haya expirado
        if (! $request->hasValidSignature()) {
            abort(403, 'Verification link has expired.');
        }

        // Si ya está verificado, solo redirigir
        if ($user->hasVerifiedEmail()) {
            // Si no está autenticado, autenticarlo
            if (!Auth::check()) {
                Auth::login($user);
            }
            return app(VerifyEmailResponse::class);
        }

        // Marcar como verificado
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            
            // Autenticar al usuario si no está logueado
            if (!Auth::check()) {
                Auth::login($user);
            }
            
            session()->flash('success', '¡Tu correo ha sido verificado con éxito!');
        }

        return app(VerifyEmailResponse::class);
    }
}
