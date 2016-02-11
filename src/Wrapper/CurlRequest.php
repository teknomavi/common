<?php
namespace Teknomavi\Common\Wrapper;

class CurlRequest implements HttpRequestInterface
{
    private $handle = null;

    public function __construct($url = null)
    {
        $this->handle = curl_init($url);
    }

    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);
    }

    public function execute()
    {
        return curl_exec($this->handle);
    }

    public function getInfo($name = null)
    {
        return curl_getinfo($this->handle, $name);
    }

    public function close()
    {
        curl_close($this->handle);
    }

    public function error()
    {
        curl_error($this->handle);
    }
}
