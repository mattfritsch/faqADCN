<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Ajouter extends AbstractController
{
    public function __invoke(): string
    {
        session_start();

        if ($this->isPost()){
            $isAdd = $this->ajoutQuestion([
                'questions' => $_POST['questions'],
                'answer' => $_POST['answer'],
                'theme' => $_POST['theme'],
            ]);
            if($isAdd){
                $this -> redirect('/gestion');
            }
            else{
                echo "Une erreur est survenue lors de l'ajout";
            }
            die;
        }

        return $this->render('admin/ajouter.html.twig', [
            'is_granted'=>$_SESSION['role'],
        ]);
    }
}