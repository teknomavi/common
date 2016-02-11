<?php
namespace Teknomavi\Common\Wrapper;

/**
 * Implements the cURL interface by simply delegating calls to the built-in cURL functions..
 * See http://www.php.net/manual/en/book.curl.php
 **/
class Curl implements CurlInterface
{
    public function close($ch)
    {
        curl_close($ch);
    }

    public function copyHandle($ch)
    {
        return curl_copy_handle($ch);
    }

    public function errno($ch)
    {
        return curl_errno($ch);
    }

    public function error($ch)
    {
        return curl_error($ch);
    }

    public function exec($ch)
    {
        return curl_exec($ch);
    }

    public function getInfo($ch, $opt = 0)
    {
        return curl_getinfo($ch, $opt);
    }

    public function init($url = null)
    {
        return curl_init($url);
    }

    public function multiAddHandle($mh, $ch)
    {
        return curl_multi_add_handle($mh, $ch);
    }

    public function multiClose($mh)
    {
        curl_multi_close($mh);
    }

    public function multiExec($mh, &$still_running)
    {
        return curl_multi_exec($mh, $still_running);
    }

    public function multiGetContent($ch)
    {
        return curl_multi_getcontent($ch);
    }

    public function multiInfoRead($mh, &$msgs_in_queue = null)
    {
        return curl_multi_info_read($mh, $msgs_in_queue);
    }

    public function multiInit()
    {
        return curl_multi_init();
    }

    public function multiRemoveHandle($mh, $ch)
    {
        return curl_multi_remove_handle($mh, $ch);
    }

    public function multiSelect($mh, $timeout = 1.0)
    {
        return curl_multi_select($mh, $timeout);
    }

    public function setOptArray($ch, $options)
    {
        return curl_setopt_array($ch, $options);
    }

    public function setOption($ch, $option, $value)
    {
        return curl_setopt($ch, $option, $value);
    }

    public function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
    }
}
