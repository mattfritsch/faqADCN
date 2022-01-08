<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Faq extends AbstractController
{
    public function __invoke(): string
    {
        $database = $this->faqDatabase();
        $dossier = $this->faqDossier();
        $conditions = $this->faqConditions();
        $info = $this->faqInfo();
        $interchu = $this->faqInterchu();
        //un seul crochet [] pour le tableau de render
        return $this->render('faq/faq.html.twig', ['database' => $database, 'dossier' => $dossier,
            'conditions' => $conditions, 'info' => $info, 'interchu' => $interchu]);
    }
}
