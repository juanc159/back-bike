<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class InventoriesDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inventories-days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculo diario de invntario';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inventoires =  Inventory::get();
        foreach ($inventoires as $key => $value) {
            $fechaRegistro = $value->created_at;
            $fechaActual = Carbon::now();
            $diasTranscurridos = $fechaActual->diffInDays($fechaRegistro);
            $value->days = $diasTranscurridos;
            $value->save();
        }
    }
}
