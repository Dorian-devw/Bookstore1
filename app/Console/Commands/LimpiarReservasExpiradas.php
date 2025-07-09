<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Carrito;

class LimpiarReservasExpiradas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservas:limpiar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar reservas expiradas del carrito';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservasExpiradas = Carrito::where('reservado_hasta', '<', now())->count();
        
        if ($reservasExpiradas > 0) {
            Carrito::where('reservado_hasta', '<', now())->delete();
            $this->info("Se eliminaron {$reservasExpiradas} reservas expiradas.");
        } else {
            $this->info('No hay reservas expiradas para limpiar.');
        }
    }
}
