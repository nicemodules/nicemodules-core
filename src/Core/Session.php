<?php

namespace NiceModules\Core;

use Exception;
use NiceModules\CoreModule\CoreModule;

use function openssl_decrypt;

class Session extends Singleton
{
    private static string $fileName = 'session.php';
    private string $sessionHash;
    protected ?string $namespace;

    /**
     * @throws Exception
     */
    protected function __construct()
    {
        $this->namespace = Context::instance()->getActivePlugin()->getClassName();
        
        $sessionFile = CoreModule::instance()->getDataDir() . DIRECTORY_SEPARATOR . self::$fileName;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!file_exists($sessionFile)) {
            throw new Exception('Core Module has not been installed yet. Please install.');
        }

        $this->sessionHash  = file_get_contents($sessionFile);

        if (empty($this->sessionHash)) {
            throw new Exception('Core Module has not been installed yet. Please install.');
        }
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $name, $default = null, $namespace = null)
    {
        if($namespace === null){
            $namespace = $this->namespace;
        }
        
        return $_SESSION[$namespace][$name] ?? $default;
    }

    public function set(string $name, $value, $namespace = null)
    {
        if($namespace === null){
            $namespace = $this->namespace;
        }
        
        $_SESSION[$namespace][$name] = $value;
    }

    public function encrypt($data, $key = null)
    {
        if (!extension_loaded('openssl')) {
            throw new Exception('This app needs the Open SSL PHP extension.');
        }

        return openssl_encrypt($data, "AES-128-ECB", $key ?? $this->sessionHash);
    }

    public function decrypt($data, $key = null)
    {
        if (!extension_loaded('openssl')) {
            throw new Exception('This app needs the Open SSL PHP extension.');
        }

        return openssl_decrypt($data, "AES-128-ECB", $key ?? $this->sessionHash);
    }

    /**
     * Use for install - generate unique for installation session key
     * @throws Exception
     */
    public static function create()
    {
        $sessionFile = CoreModule::instance()->getDataDir() . DIRECTORY_SEPARATOR . self::$fileName;

        if (file_exists($sessionFile)) {
            return;
        }

        $randomBytes = random_bytes(16);
        $key = bin2hex($randomBytes);

        file_put_contents(
            $sessionFile,
            $key
        );
    }
}