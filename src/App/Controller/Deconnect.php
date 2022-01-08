<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Deconnect extends AbstractController
{
    public function __invoke(): string
    {
        session_destroy();
        $this->redirect("/");
        return $this->render('home.html.twig', [
        ]);
    }
}