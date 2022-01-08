<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Contact extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('contact/contact.html.twig', [
        ]);
    }
}