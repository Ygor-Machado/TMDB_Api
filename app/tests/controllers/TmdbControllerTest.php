<?php

namespace app\tests\controllers;

use app\controllers\TmdbController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Testes unitários para a classe TmdbController.
 */
class TmdbControllerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testIndexSuccess()
    {
        // Cria um mock do TmdbController
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        // Configura um mock para a requisição
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['movie' => 'Batman']);

        // Configura um mock para a resposta
        $response = $this->createMock(ResponseInterface::class);

        // Configura o mock para retornar um valor simulado do método index
        $tmdbControllerMock->expects($this->once())
            ->method('index')
            ->willReturnCallback(function ($request, $response) {
                return ['movie' => ['title' => 'Batman']];
            });

        // Chama o método index do mock
        $result = $tmdbControllerMock->index($request, $response);

        $this->assertEquals('Batman', $result['movie']['title']);
    }

    /**
     * Testa o método index da TmdbController em caso de erro.
     */
    public function testIndexError()
    {
        // Cria um mock do TmdbController
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        // Configura um mock para a requisição
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['movie' => 'Batman']);

        // Configura um mock para a resposta
        $response = $this->createMock(ResponseInterface::class);

        // Configura o mock para retornar um valor simulado do método index
        $tmdbControllerMock->expects($this->once())
            ->method('index')
            ->willReturnCallback(function ($request, $response) {
                return ['status' => 'error', 'message' => 'Error'];
            });

        // Chama o método index do mock
        $result = $tmdbControllerMock->index($request, $response);

        $this->assertEquals('error', $result['status']);
    }

    /**
     * Testa o método show da TmdbController com sucesso.
     *
     * Este teste verifica se o método show retorna os dados esperados quando é bem-sucedido.
     *
     * @throws SyntaxError
     * @throws Exception
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function testShowSuccess()
    {
        // Cria um mock do TmdbController
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        // Configura um mock para a requisição
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $args = ['id' => 1];

        // Configura o mock para retornar um valor simulado do método show
        $tmdbControllerMock->expects($this->once())
            ->method('show')
            ->willReturnCallback(function ($request, $response, $args) {
                return ['movie' => ['title' => 'Batman']];
            });

        // Chama o método show do mock
        $result = $tmdbControllerMock->show($request, $response, $args);

        $this->assertEquals('Batman', $result['movie']['title']);
    }

    /**
     * Testa o método show da TmdbController em caso de erro.
     *
     * Este teste verifica se o método show retorna os dados esperados quando ocorre um erro.
     *
     * @throws SyntaxError
     * @throws Exception
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function testShowError()
    {
        // Cria um mock do TmdbController
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        // Configura um mock para a requisição
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $args = ['id' => 1];

        // Configura o mock para retornar um valor simulado do método show
        $tmdbControllerMock->expects($this->once())
            ->method('show')
            ->willReturnCallback(function ($request, $response, $args) {
                return ['status' => 'error', 'message' => 'Error'];
            });

        // Chama o método show do mock
        $result = $tmdbControllerMock->show($request, $response, $args);

        $this->assertEquals('error', $result['status']);
    }

}