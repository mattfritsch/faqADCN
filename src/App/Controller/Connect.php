<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Connect extends AbstractController
{
    public function __invoke(): string
    {
        session_start();

        if(!empty($_POST)){
            $hasError = false;
            if(empty($_POST['mail'])){
                $hasError = true;
            }
            if(empty($_POST['password'])){
                $hasError = true;
            }
            if(!$hasError){
                echo '<pre>';
                if($this->checkUserCredentials($_POST['mail'], $_POST['password'])){
                    $_SESSION['mail']=$_POST['mail'];
                    $_SESSION['password']=$_POST['password'];
                    print_r('TOUT EST OK');
                    if($this->verifAdmin($_POST['mail'])){
                        $_SESSION['role']=$this->afficheAdmin($_POST['mail']);
                        $this->redirect('/gestion');
                    }
                    else if($this->afficheAdmin($_POST['mail']) == "user"){
                        $_SESSION['role']=$this->afficheAdmin($_POST['mail']);
                        $this->redirect('/');
                    }
                    else{
                        $this->redirect('/');
                    }
                }
                else{
                    print_r('INFORMATIONS DE CONNEXION FAUSSES');
                }
                die;
            }
        }

        return $this->render('user/connect.html.twig', [
            'is_granted'=>$_SESSION['role']
        ]);
    }
}
