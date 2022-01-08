<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Modifier extends AbstractController
{
    public function __invoke(int $id): string
    {
        session_start();
        $this->afficheModifQuestion($id);
        $modifQuestion = $this->afficheModifQuestion($id);
        if($this->isPost()){
            $isModif = $this->modifQuestion([
                'questions' => $_POST['questions'],
                'answer' => $_POST['answer'],
                'theme' => $_POST['theme'],
            ], $id);
            if($isModif){
                $this -> redirect('/gestion');
            }
            else{
                echo "Une erreur est survenue lors de la modification";
            }
            die;
        }

        return $this->render('admin/modifier.html.twig', [
            'id'=>$id,
            'modifQuestion'=>$modifQuestion,
            'is_granted'=>$_SESSION['role'],
        ]);
    }
}