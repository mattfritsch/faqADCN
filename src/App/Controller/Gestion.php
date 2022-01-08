<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Gestion extends AbstractController
{
    public function __invoke(): string
    {
        session_start();
        $faq = $this->faqAll();
        //un seul crochet [] pour le tableau de render
        return $this->render('admin/gestion.html.twig',
            [
                'faq' => $faq,
                'is_granted'=>$_SESSION['role'],
            ]);
    }
}