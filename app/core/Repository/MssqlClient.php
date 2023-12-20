<?php

namespace Repository;

/*
 * This class is a wrapper for php PDO class. It connects to mssql database and
 * provides basic CRUD operations.
 */

class MssqlClient
{
    private static MssqlClient $instance;
    private \PDO $pdo;

    private function __construct(string $host,
                                 string $port,
                                 string $database,
                                 string $username,
                                 string $password)
    {
        if (!isset($this->pdo)) {
            // TODO(elianiva): figure out how to connect with encryption true since this is not ideal but it works
            $this->pdo = new \PDO("sqlsrv:Server=$host,$port;Database=$database;Encrypt=false",
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]);
        }
    }

    public static function getInstance(string $host,
                                       string $port,
                                       string $database,
                                       string $username,
                                       string $password): MssqlClient
    {
        if (!isset(self::$instance)) {
            self::$instance = new MssqlClient($host,
                $port,
                $database,
                $username,
                $password);
        }
        return self::$instance;
    }

    public function executeQuery(string $query,
                                 array  $parameters = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
        return $statement->fetchAll();
    }

    public function executeNonQuery(string $query,
                                    array  $parameters = []): void
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
    }

    public function getLastInsertedId(): int
    {
        return $this->pdo->lastInsertId();
    }
}