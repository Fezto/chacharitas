<?php

// En app/Console/Commands/GeocodeMunicipalities.php
namespace App\Console\Commands;

use App\Models\Municipality;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GeocodeMunicipalities extends Command
{
    protected $signature = 'geocode:municipalities';

    public function handle()
    {
        $municipalities = Municipality::whereNull('latitude')
            ->with('state')
            ->get();

        // Configurar User-Agent requerido por Nominatim
        Http::withHeaders([
            'User-Agent' => 'Chacharitas/1.0 (ayrtonsepch@gmail.com)'
        ]);

        foreach ($municipalities as $municipality) {
            $retry = 0;

            do {
                try {
                    $query = urlencode("{$municipality->name}, {$municipality->state->name}, Mexico");

                    $response = Http::timeout(30)->get("https://nominatim.openstreetmap.org/search", [
                        'q' => $query,
                        'format' => 'json',
                        'addressdetails' => 1,
                        'limit' => 1
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        if (!empty($data)) {
                            $municipality->update([
                                'latitude' => $data[0]['lat'],
                                'longitude' => $data[0]['lon']
                            ]);
                            $this->info("Procesado: {$municipality->name}");
                            break;
                        }
                    }

                } catch (\Exception $e) {
                    Log::error("Error con {$municipality->name}: " . $e->getMessage());
                    $retry++;
                    sleep(10 * $retry); // Backoff exponencial
                }

                sleep(1); // Respetar límite de Nominatim

            } while ($retry < 3); // Reintentar máximo 3 veces
        }
    }
}
