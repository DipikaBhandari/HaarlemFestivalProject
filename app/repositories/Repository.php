<?php

namespace App\Repositories;

use PDO;

class Repository
{
    protected $connection;

    function __construct()
    {
        require __DIR__ . '/../config/dbconfig.php';

        try {
            $this->connection = new PDO("sqlsrv:server = tcp:festivalserver.database.windows.net,1433; Database = HaarlemFestivalDatabase", "festivaladmin", "Festival123");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            print("Error connecting to SQL Server.");
            die(print_r($e));
        }

    }
}