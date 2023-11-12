<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuariosRequest;
use App\Mail\RecPass;
use App\Models\Enderecos;
use App\Models\Usuarios;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

class UsuariosController extends Controller
{
    private ?int $filial;
    private string $tabela;
    private ?Authenticatable $user;
    protected $usuarios;

    public function __construct(Request $request, Usuarios $usuarios)
    {
        $this->$usuarios = Auth::user();
        $this->tabela = 'Usuarioss';
    }


    public function index()
    {
        // $perfil = $request->get('perfil', 1);
        $data = Usuarios::getAll($this->filial);
        return response()->json($data);
    }


    public function store(UsuariosRequest $request)
    {

        try {
            DB::beginTransaction();

            $usuario = [
                'name' => $request->nome,
                'email' => $request->email,
                'password' =>$request->password,
            ];
            Usuarios::create($usuario);

            DB::commit();
            return response()->json(['msg' => "Usuario adicionado com sucesso", "conteudo" => $usuario], 200);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json(['msg' => 'Error: ' . $exception->getMessage(), 'conteudo' => ''], 400);
        }
    }

    public function show($id)
    {
        $Usuarios = Usuarios::where('id',$id)->get();
        return response()->json($Usuarios);
    }


    public function update(UsuariosRequest $request, $id)
    {

        $usuario = Usuarios::find($id);
        if (!$usuario) {
            return response()->json("Usuarios nao encontrado", 400);
        }
        $usuario = Usuarios::where('Usuarios_id',$id )->update($request);

        return response()->json(['msg' => "Atualizado com sucesso", "conteudo" => $usuario], 200);
    }


}