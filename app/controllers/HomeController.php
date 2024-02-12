<?php

namespace App\Controllers;

class HomeController
{
    private $homeService;

    public function __construct()
    {
        $this->homeService = new \App\Service\homeService();
    }

    public function index()
    {

        require __DIR__ . '/../views/festival/index.php';
    }
}