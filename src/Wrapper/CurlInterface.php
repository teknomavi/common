<?php
namespace Teknomavi\Common\Wrapper;

/**
 * Interface for PHP cURL functions.
 **/
interface CurlInterface
{
    public function __construct($url = null);

    public function setOptArray($options);

    public function setOption($option, $value);

    public function exec();

    public function getInfo($opt = 0);

    public function errno();

    public function error();

    public function close();

    public function copyHandle();

    public function multiAddHandle($mh);

    public function multiClose($mh);

    public function multiExec($mh, &$still_running);

    public function multiGetContent();

    public function multiInfoRead($mh, &$msgs_in_queue = null);

    public function multiInit();

    public function multiRemoveHandle($mh);

    public function multiSelect($mh, $timeout = 1.0);

    public function version($age = CURLVERSION_NOW);
}
