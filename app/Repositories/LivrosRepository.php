<?php


namespace App\Repositories;

use App\Models\Livros;
use App\Models\Indices;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LivrosRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $livros;
    private $indices;

    public function __construct()
    {
        $this->livros = Livros::query();
        $this->indices = Indices::query();
    }


    public function store(?array $data)
    {

        try {
            DB::beginTransaction();
            $livro = Livros::create([
                'titulo' => $data['titulo'],
                'usuario_publicador_id' => $data['usuario_publicador_id'],
            ]);

            $this->criarIndicesRecursivos($data['indices'], null, $livro);
            DB::commit();
            return response()->json(['msg' => "Livro criado com sucesso", "conteudo" => $livro], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    private function criarIndicesRecursivos($indices, $indicePaiId, Livros $livro)
    {
        foreach ($indices as $indice) {
            $novoIndice = Indices::create([
                'livro_id' => $livro->id,
                'indice_pai_id' => $indicePaiId,
                'titulo' => $indice['titulo'],
                'pagina' => $indice['pagina'],
            ]);

            // Verifica se há algum subindice e o chama recursivamente
            if (!empty($indice['subindices'])) {
                $this->criarIndicesRecursivos($indice['subindices'], $novoIndice->id, $livro);
            }
        }
    }

    public function index($request)
    {
        $livrosQuery = Livros::with('indices', 'usuario_publicador');

        if ($request->has('titulo')) {
            $livrosQuery->where('titulo', 'like', '%' . $request->input('titulo') . '%');
        }
        if ($request->has('titulo_do_indice')) {
            $livrosQuery->whereHas('indices', function ($query) use ($request) {
                $query->where('titulo', 'like', '%' . $request->input('titulo_do_indice') . '%');
            });
        }


        $livros = $livrosQuery->get();


        $livrosData = [];

        foreach ($livros as $livro) {
            $livrosData[] = [
                // 'id' => $livro->id,
                'titulo' => $livro->titulo,
                'usuario_publicador' => $livro->usuario_publicador,
                'indices' =>  $this->formatarIndicesRecursivos($livro->indices, null, $request->input('titulo_do_indice')),
            ];
        }

        return $livrosData;
    }


    private function formatarIndicesRecursivos($indices, $indicePaiId, $titulo_do_indice)
    {
        $subindicesFormatados = [];

        foreach ($indices as $indice) {
            if ($indice->indice_pai_id === $indicePaiId) {
                $subindiceFormatado = [
                    'id' => $indice->id,
                    'titulo' => $indice->titulo,
                    'pagina' => $indice->pagina,
                    'subindices' => $this->formatarIndicesRecursivos($indices, $indice->id, $titulo_do_indice),
                ];

                if ($indice->titulo == $titulo_do_indice) {
                    $subindicesFormatados[] = $subindiceFormatado;
                    return $subindicesFormatados;
                }

                if (!empty($subindiceFormatado['subindices'])) {
                    $subindicesFormatados[] = $subindiceFormatado;
                }
            }
        }

        return $subindicesFormatados;
    }





    public function update($livro_id)
    {
    }

    public function gerarXml($id)
    {
        $livros = Livros::where('id',$id)->with('indices')->get();
        $xml = new \SimpleXMLElement('<indice></indice>');

        foreach ($livros as $livro) {
            $this->gerarXmlRecursivo($xml, $livro->indices, null);
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'text/xml');
    }

    private function gerarXmlRecursivo(\SimpleXMLElement $xml, $indices, $indicePaiId)
    {
        foreach ($indices as $indice) {
            if ($indice->indice_pai_id === $indicePaiId) {
                $item = $xml->addChild('item');
                $item->addAttribute('pagina', $indice->pagina);
                $item->addAttribute('titulo', $indice->titulo);

               

                $this->gerarXmlRecursivo($item, $indices, $indice->id);
            }
        }
    }
}
