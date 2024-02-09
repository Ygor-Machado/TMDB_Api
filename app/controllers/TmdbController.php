<?php

namespace app\controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Controlador para interação com a API The Movie Database.
 */
class TmdbController extends Controller
{
    /**
     * Exibe uma lista de filmes com base na pesquisa da API TMDb.
     *
     * @param mixed $request Objeto de solicitação Slim.
     * @param mixed $response Objeto de resposta Slim.
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     *
     * @return mixed Retorna a renderização da view com os resultados da pesquisa.
     */
    public function index($request, $response)
    {
        // Obtém os parâmetros da solicitação ou usa valores padrão
        $name = $_GET['name']  ?? 'Batman';
        $page = $_GET['page'] ?? 1;

        // Chama o método da ApiController para obter os resultados da pesquisa
        $results = (new ApiController)->get($name, $page);

        // Verifica se ocorreu um erro na chamada da API
        if($results['status'] === 'error') {
            echo $results['message'];
            exit;
        }

        // Decodifica os dados da API
        $data = json_decode($results['data'], true);

        // Prepara os dados dos filmes para a renderização da view
        $movies = [];

        foreach($data['results'] as $movie) {
            $movies_tmdb = [];
            $movies_tmdb['id'] = $movie['id'];
            $movies_tmdb['title'] = $movie['title'];
            $movies_tmdb['overview'] = $movie['overview'];
            $movies_tmdb['poster_path'] = $movie['poster_path'];
            $movies_tmdb['release_date'] = $movie['release_date'];
            $movies_tmdb['vote_average'] = $movie['vote_average'];
            $movies[] = $movies_tmdb;
        }

        // Renderiza a view passando os dados para ela
        return $this->getTwig()->render($response, $this->setView('api/index'), [
            'movies' => $movies,
            'name'  => $name,
            'currentPage' => $page,
            'totalPages' => $data['total_pages'],
        ]);

    }

    /**
     * Exibe os detalhes de um filme específico com base no ID da API TMDb.
     *
     * @param mixed $request Objeto de solicitação Slim.
     * @param mixed $response Objeto de resposta Slim.
     * @param array $args Argumentos da rota, contendo o ID do filme.
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     *
     * @return mixed Retorna a renderização da view com os detalhes do filme.
     */
    public function show($request, $response, $args)
    {

        // Obtém o ID do filme dos argumentos da rota
        $id = $args['id'] ?? null;

        // Chama o método da ApiController para obter os detalhes do filme
        $results = (new ApiController)->getMovieDetails($id);

        // Verifica se ocorreu um erro na chamada da API
        if ($results['status'] === 'error') {
            echo $results['message'];
            exit;
        }

        // Decodifica os dados da API
        $data = json_decode($results['data'], true);

        // Prepara os dados do filme para a renderização da view
        $movies = [];

        if (!empty($data)) {
            $movies = [
                'id' => $data['id'],
                'title' => $data['title'],
                'overview' => $data['overview'],
                'poster_path' => $data['poster_path'],
                'release_date' => $data['release_date'],
                'vote_average' => $data['vote_average'],
            ];
        }

        // Renderiza a view passando os dados para ela
        return $this->getTwig()->render($response, $this->setView('api/show'), [
            'movies' => $movies,
        ]);
    }
}