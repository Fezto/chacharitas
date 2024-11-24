<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);

        FilamentColor::register([
            'primary' => '#f1cad0', // Azul más oscuro pero suave
            'secondary' => "#B0E0E6", // Rosa más profundo pero aún pastel
            'gray' => '#8A8A8A',  // Gris mediano para un mejor contraste
            'danger' => '#E29BB9',  // Rojo pastel con un tono más intenso
            'info' => '#6CA0DC',    // Azul suave pero más rico en saturación
            'success' => '#88C78B', // Verde pastel más vibrante
            'warning' => '#F2C078', //
        ]);
    }
}
