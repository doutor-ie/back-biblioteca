<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\LivrosService; // Importe o serviço LivrosService
use Illuminate\Support\Facades\Storage;

class GerarXmlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $livroId;

    public function __construct($livroId)
    {
        $this->livroId = $livroId;
    }

    public function handle(LivrosService $livrosService)
    {
        // Chame o método gerarXml do serviço LivrosService
        $xmlContent = $livrosService->gerarXml($this->livroId);

        Storage::put('xml/' . $this->livroId . '.xml', $xmlContent);
    }
}
