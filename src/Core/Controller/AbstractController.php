<?php

namespace Framework\Controller;

use Framework\Templating\Twig;
use PDO;
use PDOException;

abstract class AbstractController
{
    public function render(string $template, array $args = []): string
    {
        $twig = new Twig();

        return $twig->render($template, $args);
    }

    public function isPost(): bool
    {
      return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
    }

    public function redirect(string $uri): void
    {
      header("Location: $uri");
      die;
    }

    public function faqDatabase(): array{
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq WHERE theme='database'";
        $result = mysqli_query($connection, $sql);
        $database = array(array());
        while ($row = mysqli_fetch_array($result)) {
            $database[] = $row;
        }
        array_shift($database); //array_shift() supprime la première ligne du tableau
        return $database;
    }

    public function faqDossier(): array{
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq WHERE theme='dossier'";
        $result = mysqli_query($connection, $sql);
        $dossier = array(array());
        while ($row = mysqli_fetch_array($result)){
            $dossier[] = $row;
        }
        array_shift($dossier);
        return $dossier;
    }

    public function faqConditions(): array{
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq WHERE theme='conditions'";
        $result = mysqli_query($connection, $sql);
        $conditions = array(array());
        while ($row = mysqli_fetch_array($result)){
            $conditions[] = $row;
        }
        array_shift($conditions);
        return $conditions;
    }

    public function faqInfo(): array{
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq WHERE theme='informations generales'";
        $result = mysqli_query($connection, $sql);
        $info = array(array());
        while ($row = mysqli_fetch_array($result)){
            $info[] = $row;
        }
        array_shift($info);
        return $info;
    }

    public function faqInterchu(): array{
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq WHERE theme='interchu'";
        $result = mysqli_query($connection, $sql);
        $interchu = array(array());
        while ($row = mysqli_fetch_array($result)){
            $interchu[] = $row;
        }
        array_shift($interchu);
        return $interchu;
    }

    public function faqAll(): array{
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq";
        $result = mysqli_query($connection, $sql);
        $faq = array(array());
        while ($row = mysqli_fetch_array($result)){
            $faq[] = $row;
        }
        array_shift($faq);
        return $faq;
    }

    public function afficheModifQuestion(int $id) : array {
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "SELECT * FROM faq WHERE id=$id";
        $result = mysqli_query($connection, $sql);
        $modifQuestion = array(array());
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $modifQuestion[] = $row;
        }
        array_shift($modifQuestion);
        return $modifQuestion;
    }

    public function getConnection()
    {
        try {
            $connection = new PDO('mysql:host=127.0.0.1;port=3308;dbname=faqadcn', 'root', '',
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (PDOException $e) {
            echo "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
        return $connection;
    }

    public function modifQuestion(array $data, int $id) : bool{
        $connection = $this->getConnection();

        $sql = "UPDATE faq SET questions = :questions, answer = :answer, theme = :theme WHERE id = $id";
        $stmt = $connection->prepare($sql);

        $stmt->bindParam('questions', $data['questions']);
        $stmt->bindParam('answer', $data['answer']);
        $stmt->bindParam('theme', $data['theme']);

        return $stmt->execute();
    }

    public function suppQuestion(int $id) : bool {
        $connection = mysqli_connect("localhost", "root", "", "faqadcn", "3308");
        $connection->set_charset("utf8");
        $sql = "DELETE FROM faq WHERE id = $id";
        return mysqli_query($connection, $sql);
    }

    public function ajoutQuestion(array $data) : bool{
        $connection = $this->getConnection();

        $sql = "INSERT INTO faq(`id`, `questions`, `answer`,`theme`) VALUES(:id, :questions, :answer, :theme)";

        $stmt = $connection->prepare($sql);

        $id = 0;
        $stmt->bindParam('id', $id);
        $stmt->bindParam('questions', $data['questions']);
        $stmt->bindParam('answer', $data['answer']);
        $stmt->bindParam('theme', $data['theme']);

        return $stmt->execute();
    }

    public function registerUser(array $data) : bool{
        $connection = $this->getConnection();

        $sql = "INSERT INTO users(id_user, name, firstname, mail, password, role) VALUES (:id_user, :name, :firstname, 
                                                                          :mail, :password, :role)";

        $stmt = $connection->prepare($sql);
        $password = password_hash($data['password'], PASSWORD_ARGON2I);

        $id_user = 0;
        $role = "user";
        $stmt->bindParam('id_user', $id_user);
        $stmt->bindParam('name', $data['name']);
        $stmt->bindParam('firstname', $data['firstname']);
        $stmt->bindParam('mail', $data['mail']);
        $stmt->bindParam('password', $password);
        $stmt->bindParam('role', $role);

        return $stmt->execute();
    }

    public function verifAdmin(string $mail) : bool{
        $connection = $this->getConnection();
        $stmt = $connection->prepare('SELECT role from users WHERE mail=:mail');
        $stmt->bindParam('mail', $mail);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result["role"] == "admin"){
                return true;
            }
            return false;
        }
        return false;
    }

    public function afficheAdmin(string $mail) : string{
        $connection = $this->getConnection();
        $stmt = $connection->prepare('SELECT role FROM users WHERE mail=:mail');
        $stmt->bindParam('mail', $mail);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result["role"] == "admin"){
                return "admin";
            }
            return "user";
        }
        return "user";
    }

    public function checkUserCredentials(string $mail, string $password) : bool{
        $connection = $this->getConnection();
        $stmt = $connection->prepare('SELECT password FROM users WHERE mail = :mail');
        $stmt->bindParam('mail', $mail);
        if($stmt->execute()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(isset($result['password']) && password_verify($password,$result['password'])){
                return true;
            }
            return false;
        }
        return false;
    }
}
