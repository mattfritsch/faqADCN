<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Supprimer extends AbstractController
{
    public function __invoke(int $id): string
    {
        session_start();
        if(isset($_GET["confirm"]) and $_GET["confirm"] === "1"){
            $this->suppQuestion($id);
            if($this->suppQuestion($id)){
                $this->redirect('/gestion');
            }
        }
        return $this->render('admin/supprimer.html.twig', [
            'id' => $id
        ]);
    }
}