<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuariosRequest;
use App\Jobs\GerarXmlJob;
use App\Services\LivrosService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LivrosController extends Controller
{
    private string $tabela;
    private ?Authenticatable $usuarios;

    private LivrosService $livrosService;


    public function __construct(Request $request,LivrosService $livrosService )
    {
        $this->usuarios = Auth::user();
        $this->tabela = 'usuarios';
        $this->livrosService =  $livrosService;
    }

    public function index(Request $request)
    {

        return   $this->livrosService->index($request);
   
    }

    public function store(Request $request)
    {
         $data = $request->all();
        $data['usuario_publicador_id'] =   $this->usuarios->id;
     return   $this->livrosService->store($data);
    }

    public function gerarXml($livroId)
    {
        GerarXmlJob::dispatch($livroId)->onQueue('xml');
    //    return Storage::get('xml/' . $livroId . '.xml');

    }

}