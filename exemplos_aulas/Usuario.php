<?php declare (strict_types = 1);
namespace ooAlfa;
class Usuario
{
    protected $email;
    public $senha;
    public const PATH = __DIR__ . '/../../data';
    public static $logPath = __DIR__ . '/../../data/log/';

    public function __construct($email)
    {
        $this->setEmail($email);
    }

    public function setEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if ($email === false) {
            throw new \Exception("$email não é um endereço de e-mail válido.");
        }

        $this->email = $email;
    }

    public function excluir()
    {
        $arquivo = self::PATH . $this->email . '.txt';
        unlink($arquivo);
    }

    public function cadastrar()
    {
        $this->senha = password_hash($this->senha, PASSWORD_ARGON2I);

        // Cria, grava e anexa dados ao arquivo
        $arquivo = self::PATH . $this->email . '.txt';
    
        file_put_contents($arquivo, $this->senha);
    }

    public function autenticar() : bool
    {
    $arquivo = self::PATH . $this->email;
    $hash = file_get_contents($arquivo);
    return password_verify($this->senha, $hash);
    }

    public static function registrarlog(String $evento): void
    {
        $dateTime = new \DateTime();
        $arquivo = sprintf('%s.log', $dateTime->format('Y-m-d')) ;
        $linha = sprintf('[%s] %s%s', $dateTime->format('H:i:s'), $evento, PHP_EOL);
        file_put_contents(self::$logPath . '/' . $arquivo, $linha, FILE_APPEND);
    }

    public function _destruct()
    {
        self::registrarlog('objeto destrido');
    }
}
