<?php

namespace Zevitagem\LegoAuth\Services\Login;

class LoginConfig
{
    private $url        = '';
    private $config     = [];
    private $options    = [];
    private $parameters = [];

    public function __construct()
    {
        $this->parameters = array();
        $this->url        = env('AUTHORIZATION_APP_URL');
    }

    public function setParameters($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getHeaders()
    {
        return [
            'route' => 'access'
        ];
    }
}