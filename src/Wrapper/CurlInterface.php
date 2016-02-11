<?php
namespace Teknomavi\Common\Wrapper;

/**
 * Interface for PHP cURL functions.
 **/
interface CurlInterface
{
    public function close($ch);

    public function copyHandle($ch);

    public function errno($ch);

    public function error($ch);

    public function exec($ch);

    public function getInfo($ch, $opt = 0);

    public function init($url = null);

    public function multiAddHandle($mh, $ch);

    public function multiClose($mh);

    public function multiExec($mh, &$still_running);

    public function multiGetContent($ch);

    public function multiInfoRead($mh, &$msgs_in_queue = null);

    public function multiInit();

    public function multiRemoveHandle($mh, $ch);

    public function multiSelect($mh, $timeout = 1.0);

    public function setOptArray($ch, $options);

    public function setOption($ch, $option, $value);

    public function version($age = CURLVERSION_NOW);
}
