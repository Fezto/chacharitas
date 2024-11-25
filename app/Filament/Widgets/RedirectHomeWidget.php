<?php

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Widgets\Widget;

class RedirectHomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.redirect-home-widget';
    protected static bool $isLazy = false;

    public static function canView(): bool
    {
        return true;
    }

    public function getActions(): array
    {
        return [
            Action::make('goHome')
                ->label('Ir al Inicio')
                ->icon('heroicon-o-home')
                ->url('/') // Redirige a la ruta raíz
                ->color('primary'), // Personaliza el color del botón
        ];
    }
}
