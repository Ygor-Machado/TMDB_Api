<?php

namespace app\controllers;

/**
 * Controlador para interação com a API do The Movie Database.
 */
class ApiController extends Controller
{
    /**
     * Obtém os resultado de pesquisa da API.
     *
     * @param string $name O nome do filme para pesquisar.
     * @param int $page A página da lista de filmes.
     *
     * @return array Retorna um array com os dados dos filmes.
     */
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

    /**
     * Obtém os detalhes de um filme.
     *
     * @param int $id O ID do filme.
     *
     * @return array Retorna um array com status, mensagem e dados da API.
     */
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