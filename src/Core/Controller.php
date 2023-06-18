<?php

namespace NiceModules\Core;

abstract class Controller
{
    const ERROR = 0;
    const SUCCESS = 1;

    protected array $errors = [];
    protected array $response = [];
    protected $timeBefore;

    protected Context $context;
    protected Lang $lang;

    public function __construct()
    {
        $this->context = Context::instance();
        $this->lang =  $this->context->getLang();
        $this->timeBefore = array_sum(explode(' ', microtime()));
    }
    
    public function getRequestParameter($name){
        return json_decode(Context::instance()->getRequest()->get($name));
    }
    
    public function getCurrentExeTime()
    {
        $timeAfter = array_sum(explode(' ', microtime()));
        $time = $timeAfter - $this->timeBefore;
        return round($time, 3) . 's';
    }
    
    public function getContext(): mixed
    {
        return $this->context;
    }

    protected function setResponse(int $status, string $msg = '')
    {
        $this->response['status'] = $status;
        $this->response['messages'][] = $msg;
    }

    protected function setResponseStatus(int $status)
    {
        $this->response['status'] = $status;
    }
    
    protected function addResponseMessage(string $message)
    {
        $this->response['messages'][] = $message;
    }


    protected function addResponseTime()
    {
        $this->response['time'] = $this->getCurrentExeTime();
    }

    protected function renderJsonResponse()
    {
        $this->addResponseTime();
        echo json_encode($this->response);
        exit;
    }
    
    protected function getAjaxResponseStatus(): int
    {
        return $this->response['status'];
    }
    
    protected function getResponseMessages(): array
    {
        return $this->response['messages'];
    }
    
    protected function addError(string $error)
    {
        $this->errors[] = $error;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function isAjaxPostRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(
                $_SERVER['HTTP_X_REQUESTED_WITH']
            ) == 'xmlhttprequest';
    }
}