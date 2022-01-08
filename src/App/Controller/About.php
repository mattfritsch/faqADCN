<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class About extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('about/about.html.twig', [
        ]);
    }
}
