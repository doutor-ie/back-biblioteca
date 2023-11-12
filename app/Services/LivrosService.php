<?php

namespace App\Services;


use App\Repositories\LivrosRepository;


class LivrosService
{
    private LivrosRepository $livroRepository;

    public function __construct(LivrosRepository $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function store($data)
    {
      return  $this->livroRepository->store($data);
    }


    public function index($data)
    {
      return  $this->livroRepository->index($data);
    }

    public function gerarXml($id)
    {
      return  $this->livroRepository->gerarXml($id);
    }


}