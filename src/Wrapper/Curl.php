<?php
namespace Teknomavi\Common\Wrapper;

/**
 * Implements the cURL interface by simply delegating calls to the built-in cURL functions..
 *
 * @see http://www.php.net/manual/en/book.curl.php
 **/
class Curl implements CurlInterface
{
    private $handle;

    public function __construct($url = null)
    {
        $this->handle = curl_init($url);
    }

    public function setOptArray($options)
    {
        return curl_setopt_array($this->handle, $options);
    }

    public function setOption($option, $value)
    {
        return curl_setopt($this->handle, $option, $value);
    }

    public function exec()
    {
        return curl_exec($this->handle);
    }

    public function getInfo($opt = 0)
    {
        return curl_getinfo($this->handle, $opt);
    }

    public function errno()
    {
        return curl_errno($this->handle);
    }

    public function error()
    {
        return curl_error($this->handle);
    }

    public function close()
    {
        curl_close($this->handle);
    }

    public function copyHandle()
    {
        return curl_copy_handle($this->handle);
    }

    public function multiAddHandle($mh)
    {
        return curl_multi_add_handle($mh, $this->handle);
    }

    public function multiClose($mh)
    {
        curl_multi_close($mh);
    }

    public function multiExec($mh, &$still_running)
    {
        return curl_multi_exec($mh, $still_running);
    }

    public function multiGetContent()
    {
        return curl_multi_getcontent($this->handle);
    }

    public function multiInfoRead($mh, &$msgs_in_queue = null)
    {
        return curl_multi_info_read($mh, $msgs_in_queue);
    }

    public function multiInit()
    {
        return curl_multi_init();
    }

    public function multiRemoveHandle($mh)
    {
        return curl_multi_remove_handle($mh, $this->handle);
    }

    public function multiSelect($mh, $timeout = 1.0)
    {
        return curl_multi_select($mh, $timeout);
    }

    public function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
    }
}
