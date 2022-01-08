<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Register extends AbstractController
{
    public function __invoke(): string
    {
        {
            session_start();
            if($this->isPost()){
                $isRegistered = $this->registerUser([
                    'name' => $_POST['name'],
                    'firstname' => $_POST['firstname'],
                    'mail' => $_POST['mail'],
                    'password' => $_POST['password'],
                ]);
                if($isRegistered){
                    if($this->checkUserCredentials($_POST['mail'], $_POST['password'])){
                        $_SESSION['mail']=$_POST['mail'];
                        $_SESSION['password']=$_POST['password'];
                        print_r('TOUT EST OK');
                        if ($this->verifAdmin($_POST['mail'])) {
                            $_SESSION['role'] = $this->afficheAdmin($_POST['mail']);
                            $this->redirect('/gestion');
                        } else if ($this->afficheAdmin($_POST['mail']) == "user") {
                            $_SESSION['role'] = $this->afficheAdmin($_POST['mail']);
                            $this->redirect('/');
                        } else {
                            $this->redirect('/');
                        }
                    }
                }
                else {
                    echo 'Une erreur est survenue pendant votre inscription !';
                }
                die;
            }
            return $this->render('user/register.html.twig');
        }
    }
}