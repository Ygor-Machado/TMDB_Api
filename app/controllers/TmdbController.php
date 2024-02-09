<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TmdbController extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index($request, $response)
    {
        $name = $_GET['name']  ?? 'Batman';
        $page = $_GET['page'] ?? 1;

        $results = (new ApiController)->get($name, $page);

        if($results['status'] === 'error') {
            echo $results['message'];
            exit;
        }

        $data = json_decode($results['data'], true);

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
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function show($request, $response, $args)
    {
        $id = $args['id'] ?? null;
        $results = (new ApiController)->getMovieDetails($id);

        if ($results['status'] === 'error') {
            echo $results['message'];
            exit;
        }

        $data = json_decode($results['data'], true);

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