<?php

namespace app\controllers;

class ApiController extends Controller
{
    public  function get($name, $page): array
    {
        // Inicializa uma sessão cURL
        $curl = curl_init();

        // Configura as opções do cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?query=" . $name. "&api_key=" .API_KEY. "&language=pt-BR&page=" . $page,

            CURLOPT_RETURNTRANSFER => true, // Retorna o resultado como string
            CURLOPT_CUSTOMREQUEST => 'GET', // Método de requisição
            CURLOPT_SSL_VERIFYPEER => false, // Não verificar o SSL, não usar em produção
        ));

        // Executa o cURL e armazena na variavel
        $response = curl_exec($curl);

        // Verifica os erros e armazena na variavel
        $err = curl_error($curl);

        // Fecha a sessão cURL
        curl_close($curl);

        // Retorna um array com os dados
        return [
            'status'  => $err ? 'error' : 'success',
            'message' => $err,
            'data'    => $err ? null : $response,
        ];
    }

    public function getMovieDetails($id): array
    {
        // Inicializa uma sessão cURL
        $curl = curl_init();

        // Configura as opções do cURL para obter os detalhes do filme
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.themoviedb.org/3/movie/{$id}?api_key=" . API_KEY . "&language=pt-BR",
            CURLOPT_RETURNTRANSFER => true, // Retorna o resultado como string
            CURLOPT_CUSTOMREQUEST => 'GET', // Método de requisição
            CURLOPT_SSL_VERIFYPEER => false, // Não verificar o SSL, não usar em produção
        ));

        // Executa o cURL e armazena na variável
        $response = curl_exec($curl);

        // Verifica os erros e armazena na variável
        $err = curl_error($curl);

        // Fecha a sessão cURL
        curl_close($curl);

        // Retorna um array com os dados
        return [
            'status'  => $err ? 'error' : 'success',
            'message' => $err,
            'data'    => $err ? null : $response,
        ];
    }
}