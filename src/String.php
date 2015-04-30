<?php

namespace Teknomavi\Common;

class String
{

    public static $lowerTR = array( "ç", "ğ", "i", "ı", "ö", "ş", "ü" );
    public static $upperTR = array( "Ç", "Ğ", "İ", "I", "Ö", "Ş", "Ü" );
    public static $lowerEN = array( "c", "g", "i", "i", "o", "s", "u" );
    public static $upperEN = array( "C", "G", "I", "I", "O", "S", "U" );

    /**
     * strtoupper() The string being uppercased.
     *
     * @param  string $string
     *
     * @return string
     */
    public static function strtoupper( $string )
    {
        $string = str_replace( self::$lowerTR, self::$upperTR, $string );

        return mb_strtoupper( $string );
    }

    /**
     * strtolower() The string being lowercased.
     *
     * @param string $string
     *
     * @return string
     */
    public static function strtolower( $string )
    {
        $string = str_replace( self::$upperTR, self::$lowerTR, $string );

        return mb_strtolower( $string, 'UTF-8.tr' );
    }

    /**
     * ucfirst() Make a string's first character uppercase
     *
     * @param string $string
     *
     * @return string
     */
    public static function ucfirst( $string )
    {
        return self::strtoupper( mb_substr( $string, 0, 1 ) ) . self::strtolower( mb_substr( $string, 1 ) );
    }

    /**
     * ucwords() Make each word's first character uppercase
     *
     * @param string $string
     *
     * @return string
     */
    public static function ucwords( $string )
    {
        $words = explode( " ", $string );
        $words = array_map( "self::ucfirst", $words );

        return implode( " ", $words );
    }

    /**
     * Türkçe için uyarlanmış versiyonudur.
     *
     * @param string $string
     *
     * @return string
     */
    public static function uctitle( $string )
    {
        $words = explode( " ", self::strtolower( $string ) );
        $words = array_map( "self::ucfirst", $words );

        return implode( " ", $words );
    }

    /**
     * Türkçe karakterleri İngilizce karşılıkları ile değiştirir.
     *
     * @param  string $string
     *
     * @return string
     */
    public static function TRtoEN( $string )
    {
        $string = str_replace( self::$lowerTR, self::$lowerEN, $string );
        $string = str_replace( self::$upperTR, self::$upperEN, $string );

        return $string;
    }

    /**
     * Metnin başındaki ve sonundaki boşlukları temizler. Aradaki boşlukların fazlalıklarını alır
     *
     * @param string $string
     * @param string $charList
     *
     * @return string
     */
    public static function clear( $string, $charList = '\s\xA0' )
    {
        $string = str_replace( "&nbsp;", " ", $string );

        return trim( preg_replace( '@[' . $charList . ']+@u', ' ', $string ) );
    }

    /**
     * Metnin başındaki ve sonundaki boşlukları temizler.
     *
     * @param string $string
     * @param string $charlist
     *
     * @return string
     */
    public static function trim( $string, $charlist = '\s\xA0' )
    {
        return trim( preg_replace( '@^[' . $charlist . ']+(.*)[' . $charlist . ']+$@u', '\\1', $string ) );
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function createSlug( $string )
    {
        if ($string == '') {
            return $string;
        }
        $string = html_entity_decode( $string );
        $string = self::clear( str_replace( array( "/", "'" ), array( " ", "" ), $string ) );
        $string = self::TRtoEN( $string );
        if (empty( $string )) {
            return "";
        }
        $string = iconv( "UTF-8", "ASCII//TRANSLIT", $string );
        $string = preg_replace( '@[^a-z0-9]@u', " ", strtolower( $string ) );
        $string = preg_replace( '@[\s]{1,}@', "-", self::clear( $string ) );

        return $string;
    }

    /**
     * Generates random string
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandom( $length = 10 )
    {
        $max = ceil( $length / 40 );
        $random = '';
        for ($i = 0; $i < $max; $i++) {
            $random .= sha1( microtime( true ) . mt_rand( 10000, 90000 ) );
        }

        return substr( $random, 0, $length );
    }
}
