<?php

namespace app\database;

use PDO;
use PDOException;

/**
 * Classe para estabelecer a conexão com o banco de dados utilizando PDO.
 */
class Connection
{

    /**
     * Instância compartilhada do PDO para reutilização.
     *
     * @var PDO|null
     */
    private static $pdo = null;

    /**
     * Retorna a instância do PDO para a conexão com o banco de dados.
     *
     * @return PDO Retorna a instância do PDO configurada para o banco de dados.
     */
    public static function connection()
    {
        // Se já existe uma instância do PDO, retorna a mesma instância
        if(static::$pdo) {
            return static::$pdo;
        }

        try{
            static::$pdo = new PDO('mysql:host=localhost;dbname=slim4', 'root','1234', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);

            // Retorna a instância do PDO
            return static::$pdo;

        }catch(PDOException $e){
            // Em caso de erro na conexão, exibe a mensagem de exceção e encerra a execução
            die($e->getMessage());
        }

    }

}