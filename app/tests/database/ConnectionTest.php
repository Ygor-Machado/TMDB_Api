<?php

namespace app\tests\database;

use PDO;
use PHPUnit\Framework\TestCase;
use app\database\Connection;

class ConnectionTest extends TestCase
{
    public function testConnection()
    {
        $pdo = Connection::connection();

        $this->assertInstanceOf(PDO::class, $pdo);

        // Verifica se a string de status contém 'localhost via TCP/IP'
        $this->assertStringContainsString('localhost via TCP/IP', $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS));
    }
}
