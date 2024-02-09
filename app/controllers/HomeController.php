<?php

namespace App\Controllers;

class HomeController
{
    private $listingService;

    public function __construct()
    {
        $this->listingService = new \App\Services\ListingService();
    }

    public function index()
    {
        require __DIR__ . '/../views/festival/index.php';
    }
}