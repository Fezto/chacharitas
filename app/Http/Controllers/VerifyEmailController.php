<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Http\Requests\VerifyEmailRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param VerifyEmailRequest $request
     * @return VerifyEmailResponse
     */
    public function __invoke(VerifyEmailRequest $request): VerifyEmailResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return app(VerifyEmailResponse::class);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            session()->flash('success', '¡Tu correo ha sido verificado con éxito!');
        }

        return app(VerifyEmailResponse::class);
    }
}
