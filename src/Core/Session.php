<?php

namespace NiceModules\Core;

use Exception;

use function openssl_decrypt;

class Session extends Singleton
{
    /**
     * @var string
     */
    protected string $key = '';
    protected static string $keySalt;
    protected string $sessionSalt;
    protected static string $fileName = 'session.php';

    /**
     * @throws Exception
     */
    protected function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (file_exists(DATA_DIR . self::$fileName)) {
            require_once(DATA_DIR . self::$fileName);
        }

        if (!isset($key) || !isset($keySalt) || !isset($sessionSalt)) {
            throw new Exception('Core Module has not been installed yet. Please install.');
        }

        $this->key = $key;
        $this->keySalt = $keySalt;
        $this->sessionSalt = $sessionSalt;
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed
    {
        return $_SESSION[self::class][$name] ?? $default;
    }

    public function set(string $name, mixed $value)
    {
        $_SESSION[self::class][$name] = $value;
    }

    /**
     * @return bool
     */
    public function isOpened(): bool
    {
        if ($this->get('session_hash') && $this->get('key') === $this->key) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     */
    public function open(string $key): void
    {
        self::set('session_hash', $this->getSessionHash($key));
        self::set('key', self::getKeyHash($key));
    }

    protected function getSessionHash($key)
    {
        return hash('sha512', $key . $this->sessionSalt);
    }

    public function encrypt($data, $key = null)
    {
        if (!extension_loaded('openssl')) {
            throw new Exception('This app needs the Open SSL PHP extension.');
        } 
        
        return openssl_encrypt($data, "AES-128-ECB", $key ?? $this->get('session_hash'));
    }

    public function decrypt($data, $key = null)
    {
        if (!extension_loaded('openssl')) {
            throw new Exception('This app needs the Open SSL PHP extension.');
        }
        
        return openssl_decrypt($data, "AES-128-ECB", $key ?? $this->get('session_hash'));
        
    }

    protected static function getKeyHash($key)
    {
        return hash('sha512', $key . self::$keySalt);
    }

    /**
     * Use for install - generate session keys
     * @param $key
     */
    public static function create($key)
    {
        self::$keySalt = md5(uniqid('IDKFA', true));
        $sessionSalt = md5(uniqid('IDDQD', true));

        $codeLines = [
            '<?php $keySalt = ' . self::$keySalt . ' ; ?>',
            '<?php $sessionSalt = ' . $sessionSalt . ' ; ?>',
            '<?php $key = ' . self::getKeyHash($key) . ' ; ?>',
        ];

        file_put_contents(
            DATA_DIR . self::$fileName,
            implode(PHP_EOL, $codeLines)
        );
    }
}