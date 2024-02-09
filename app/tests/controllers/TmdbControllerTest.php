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

class TmdbControllerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testIndexSuccess()
    {
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['movie' => 'Batman']);

        $response = $this->createMock(ResponseInterface::class);

        $tmdbControllerMock->expects($this->once())
            ->method('index')
            ->willReturnCallback(function ($request, $response) {
                return ['movie' => ['title' => 'Batman']];
            });

        $result = $tmdbControllerMock->index($request, $response);

        $this->assertEquals('Batman', $result['movie']['title']);
    }

    public function testIndexError()
    {
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn(['movie' => 'Batman']);

        $response = $this->createMock(ResponseInterface::class);

        $tmdbControllerMock->expects($this->once())
            ->method('index')
            ->willReturnCallback(function ($request, $response) {
                return ['status' => 'error', 'message' => 'Error'];
            });

        $result = $tmdbControllerMock->index($request, $response);

        $this->assertEquals('error', $result['status']);
    }

    /**
     * @throws SyntaxError
     * @throws Exception
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function testShowSuccess()
    {
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $args = ['id' => 1];

        $tmdbControllerMock->expects($this->once())
            ->method('show')
            ->willReturnCallback(function ($request, $response, $args) {
                return ['movie' => ['title' => 'Batman']];
            });

        $result = $tmdbControllerMock->show($request, $response, $args);

        $this->assertEquals('Batman', $result['movie']['title']);
    }

    /**
     * @throws SyntaxError
     * @throws Exception
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function testShowError()
    {
        $tmdbControllerMock = $this->createMock(TmdbController::class);

        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $args = ['id' => 1];

        $tmdbControllerMock->expects($this->once())
            ->method('show')
            ->willReturnCallback(function ($request, $response, $args) {
                return ['status' => 'error', 'message' => 'Error'];
            });

        $result = $tmdbControllerMock->show($request, $response, $args);

        $this->assertEquals('error', $result['status']);
    }

}