<?php
declare(strict_types=1);
require 'Abstraction/BancoDeDados.php';

class Pessoa implements PosAlfa\Abstraction\BancoDeDados {

    const DSN = 'mysql:host=localhost;dbname=trab_galvao';
    const USER = 'root';
    const PASS = 'root';

    public $id;
    public $nome;

    public function getID() {
        return $this->id;
      }
      
    public function setID($id) {
    $this->id= $id;
    }

    public function getNome() {
        return $this->nome;
    }
      
    public function setNome($nome) {
        $this->nome= $nome;
    }

    public function connect(string $dsn, string $user, string $pass): \PDO
    {
        $conn = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE  => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_CASE     => \PDO::CASE_LOWER
        ]);
        return $conn;
    }

    public function prepare(\PDO $pdo, string $sql): \PDOStatement
    {
        return $pdo->prepare($sql);
    }

    public function select() {
        try {
           $pdo = $this->connect(self::DSN, self::USER, self::PASS);
           $stmt = $this->prepare($pdo, 'SELECT * FROM pessoa');
           $stmt->execute();
           var_dump($stmt->fetch());
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}