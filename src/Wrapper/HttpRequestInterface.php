<?php
namespace Teknomavi\Common\Wrapper;

interface HttpRequestInterface
{
    public function setOption($name, $value);

    public function execute();

    public function getInfo($name);

    public function close();
}
