<?php
namespace Teknomavi\Common;

/**
 * Class Text
 *
 * @package Teknomavi\Common
 */
class Text
{
    public static $lowerTR = array("ç", "ğ", "i", "ı", "ö", "ş", "ü");
    public static $upperTR = array("Ç", "Ğ", "İ", "I", "Ö", "Ş", "Ü");
    public static $lowerEN = array("c", "g", "i", "i", "o", "s", "u");
    public static $upperEN = array("C", "G", "I", "I", "O", "S", "U");

    /**
     * Metni büyük harfe çevirir.
     *
     * @param  string $string
     *
     * @return string
     */
    public static function strToUpper($string)
    {
        $string = str_replace(self::$lowerTR, self::$upperTR, $string);
        return mb_strtoupper($string, 'UTF-8.tr');
    }

    /**
     * Metni küçük harfe çevirir
     *
     * @param string $string
     *
     * @return string
     */
    public static function strToLower($string)
    {
        $string = str_replace(self::$upperTR, self::$lowerTR, $string);
        return mb_strtolower($string, 'UTF-8.tr');
    }

    /**
     * Metnin ilk harfini büyük yapar
     *
     * @param string $string
     *
     * @return string
     */
    public static function ucFirst($string)
    {
        return self::strToUpper(mb_substr($string, 0, 1)) . self::strToLower(mb_substr($string, 1));
    }

    /**
     * Tüm kelimelerin ilk harflerini büyük yapar
     *
     * @param string $string
     *
     * @return string
     */
    public static function ucWords($string)
    {
        $words = explode(" ", $string);
        $words = array_map("self::ucFirst", $words);
        return implode(" ", $words);
    }

    /**
     * Türkçe için uyarlanmış versiyonudur.
     *
     * @param string $string
     *
     * @return string
     */
    public static function uctitle($string)
    {
        $words = explode(" ", self::strToLower($string));
        $words = array_map("self::ucFirst", $words);
        return implode(" ", $words);
    }

    /**
     * Türkçe karakterleri İngilizce karşılıkları ile değiştirir.
     *
     * @param  string $string
     *
     * @return string
     */
    public static function TR2EN($string)
    {
        $string = str_replace(self::$lowerTR, self::$lowerEN, $string);
        $string = str_replace(self::$upperTR, self::$upperEN, $string);
        return $string;
    }

    /**
     * Metnin başındaki ve sonundaki boşlukları temizler. Aradaki boşlukların fazlalıklarını alır.
     *
     * @param string $string
     * @param string $charList
     *
     * @return string
     */
    public static function clear($string, $charList = '\s\xA0')
    {
        $string = str_replace("&nbsp;", " ", $string);
        return trim(preg_replace('@[' . $charList . ']+@u', ' ', $string));
    }

    /**
     * Metnin başındaki ve sonundaki boşlukları temizler.
     *
     * @param string $string
     * @param string $charlist
     *
     * @return string
     */
    public static function trim($string, $charlist = '\s\xA0')
    {
        return trim(preg_replace('@^[' . $charlist . ']+(.*)[' . $charlist . ']+$@u', '\\1', $string));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function createSlug($string)
    {
        if ($string == '') {
            return $string;
        }
        $string = html_entity_decode($string);
        $string = self::clear(str_replace(array("/", "'"), array(" ", ""), $string));
        $string = self::TR2EN($string);
        if (empty($string)) {
            return "";
        }
        $string = iconv("UTF-8", "ASCII//TRANSLIT", $string);
        $string = preg_replace('@[^a-z0-9]@u', " ", strtolower($string));
        $string = preg_replace('@[\s]{1,}@', "-", self::clear($string));
        return $string;
    }

    /**
     * Generates random string
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandom($length = 10)
    {
        $max = ceil($length / 40);
        $random = '';
        for ($i = 0; $i < $max; $i++) {
            $random .= sha1(microtime(true) . mt_rand(10000, 90000));
        }
        return substr($random, 0, $length);
    }
}
