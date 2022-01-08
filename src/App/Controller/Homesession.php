<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Homesession extends AbstractController
{
    public function __invoke(): string
    {
        session_start();
        return $this->render('home.html.twig', [
            'is_granted'=>$_SESSION['role'],
        ]);
    }
}