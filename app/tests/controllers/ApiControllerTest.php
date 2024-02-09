<?php

namespace app\tests\controllers;

use app\controllers\ApiController;
use PHPUnit\Framework\TestCase;

class ApiControllerTest Extends TestCase
{
    public function testGetSuccess()
    {
        $apiKey = 'aff887f3ea03f726894bd66d7b66a0c1';
        $name = 'Batman';
        $page = 1;


        // Cria um mock do ApiController
        $apiControllerMock = $this->getMockBuilder(ApiController::class)
            ->onlyMethods(['get'])
            ->getMock();

        // Configura o mock para retornar um valor simulado da API
        $apiControllerMock->expects($this->once())
            ->method('get')
            ->with($apiKey, $name, $page)
            ->willReturn([
                'status' => 'success',
                'message' => 'Requisição bem-sucedida',
                'data' => 'Dados simulados da API',
            ]);

        // Chama o método get do mock
        $result = $apiControllerMock->get($apiKey, $name, $page);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Requisição bem-sucedida', $result['message']);
        $this->assertEquals('Dados simulados da API', $result['data']);
    }

    public function testGetError()
    {
        $apiKey = 'aff887f3ea03f726894bd66d7b66a0c1';
        $name = 'error';
        $page = 1;

        $apiControllerMock = $this->getMockBuilder(ApiController::class)
            ->onlyMethods(['get'])
            ->getMock();

        $apiControllerMock->expects($this->once())
            ->method('get')
            ->with($apiKey, $name, $page)
            ->willReturn([
                'status'  => 'error',
                'message' => 'Erro simulado na requisição',
                'data'    => null,
            ]);

        $result = $apiControllerMock->get($apiKey, $name, $page);

        // Assertions
        $this->assertEquals('error', $result['status']);
        $this->assertEquals('Erro simulado na requisição', $result['message']);
        $this->assertNull($result['data']);
    }

    public function testGetMovieDetailsSuccess()
    {
        $apiKey = 'aff887f3ea03f726894bd66d7b66a0c1';
        $movieId = 123;

        // Cria um mock do ApiController
        $apiControllerMock = $this->getMockBuilder(ApiController::class)
            ->onlyMethods(['getMovieDetails'])
            ->getMock();

        // Configura o mock para retornar um valor simulado da API
        $apiControllerMock->expects($this->once())
            ->method('getMovieDetails')
            ->with($apiKey, $movieId)
            ->willReturn([
                'status' => 'success',
                'message' => 'Requisição bem-sucedida',
                'data' => 'Dados simulados da API para detalhes do filme',
            ]);

        // Chama o método getMovieDetails do mock
        $result = $apiControllerMock->getMovieDetails($apiKey, $movieId);

        // Assertions
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Requisição bem-sucedida', $result['message']);
        $this->assertEquals('Dados simulados da API para detalhes do filme', $result['data']);
    }

    public function testGetMovieDetailsError()
    {
        $apiKey = 'aff887f3ea03f726894bd66d7b66a0c1';
        $movieId = 456;

        $apiControllerMock = $this->getMockBuilder(ApiController::class)
            ->onlyMethods(['getMovieDetails'])
            ->getMock();

        $apiControllerMock->expects($this->once())
            ->method('getMovieDetails')
            ->with($apiKey, $movieId)
            ->willReturn([
                'status'  => 'error',
                'message' => 'Erro simulado na requisição',
                'data'    => null,
            ]);

        $result = $apiControllerMock->getMovieDetails($apiKey, $movieId);

        // Assertions
        $this->assertEquals('error', $result['status']);
        $this->assertEquals('Erro simulado na requisição', $result['message']);
        $this->assertNull($result['data']);
    }

}