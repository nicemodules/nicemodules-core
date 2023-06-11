<?php

namespace NiceModules\Core;

class Request
{
    const INT = 'INT';
    const FLOAT = 'FLOAT';
    const XSS = 'XSS';
    const EMAIL = 'EMAIL';
    const URL = 'URL';
    const ROUTING = 'ROUTING';


    protected array $data;

    public function __construct()
    {
        $this->data = $_REQUEST;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @param string|null $sanitizeType
     * @return array|float|int|mixed|string|null
     */
    public function get(string $key, $default = false, $sanitizeType = null)
    {
        if (isset($this->data[$key])) {
            $value = $this->data[$key];
            return $this->sanitize($value, $sanitizeType);
        }

        return $default;
    }

    public function sanitize($input, ?string $type)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->sanitize($value, $type);
            }
        } else {
            switch ($type) {
                case  self::INT:
                    $input = (int)$input;
                    break;
                case  self::FLOAT:
                    $input = (float)$input;
                    break;
                case  self::EMAIL:
                    $input = filter_var($input, FILTER_SANITIZE_EMAIL);
                    break;
                case  self::URL:
                    $input = filter_var($input, FILTER_SANITIZE_URL);
                    break;
                case  self::ROUTING:
                    $input = preg_match('/^[a-zA-Z0-9_.-\/]*$/', $input) ? $input : false;
                    break;
                case  self::XSS:
                    $input = trim(htmlspecialchars((string)$input, ENT_QUOTES));
                    break;
            }
        }

        return $input;
    }
}