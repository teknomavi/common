<?php
namespace Teknomavi\Tests\Common;

use Teknomavi\Common\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Teknomavi\Common\Text::strToUpper
     */
    public function testStrToUpper()
    {
        $this->assertEquals('QWERTYUIOPĞÜASDFGHJKLŞİZXCVBNMÖÇ', Text::strToUpper('qwertyuıopğüasdfghjklşizxcvbnmöç'));
    }

    /**
     * @covers Text::strToLower
     */
    public function testStrToLower()
    {
        $this->assertEquals('qwertyuıopğüasdfghjklşizxcvbnmöç', Text::strToLower('QWERTYUIOPĞÜASDFGHJKLŞİZXCVBNMÖÇ'));
    }

    /**
     * @covers Teknomavi\Common\Text::strToUpper
     * @covers Teknomavi\Common\Text::strToLower
     * @covers Teknomavi\Common\Text::ucFirst
     */
    public function testUcFirst()
    {
        $this->assertEquals('Deneme metin', Text::ucFirst('deneme Metin'));
        $this->assertEquals('İlginç şeyler', Text::ucFirst('İlginç Şeyler'));
        $this->assertEquals('Deneme metin', Text::ucFirst('DENEME Metin'));
    }

    /**
     * @covers Teknomavi\Common\Text::strToUpper
     * @covers Teknomavi\Common\Text::strToLower
     * @covers Teknomavi\Common\Text::ucFirst
     * @covers Teknomavi\Common\Text::ucWords
     */
    public function testUcWords()
    {
        $this->assertEquals('Her Bir Kelimenin İlk Harfinin Büyük Olması Lazım', Text::ucWords('Her bir kelimenin ilk harfinin büyük olması lazım'));
        $this->assertEquals('Sadece İlk Harflerin Büyük Kalması Lazım', Text::ucWords('SADECE İLK HARFLERİN BÜYÜK KALMASI LAZIM'));
        $this->assertEquals('Tek Harf Testi İ Ş Ğ Ü', Text::ucWords('Tek harf testi i ş Ğ Ü'));
    }

    /**
     * @covers Teknomavi\Common\Text::strToUpper
     * @covers Teknomavi\Common\Text::strToLower
     * @covers Teknomavi\Common\Text::ucFirst
     * @covers Teknomavi\Common\Text::ucTitle
     */
    public function testUcTitle()
    {
        $this->assertEquals('Ali okula git. Run lola run', Text::ucTitle('Ali Okula Git. Run Lola Run'));
        $this->assertEquals('Bugüne özel kargo bedava! sadece 5.90tl', Text::ucTitle('Bugüne özel kargo BEDAVA! Sadece 5.90TL'));
    }

    /**
     * @covers Teknomavi\Common\Text::turkishToEnglish
     */
    public function testTurkishToEnglish()
    {
        $this->assertEquals('ocsiguiOCSIGUI', Text::turkishToEnglish('öçşiğüıÖÇŞİĞÜI'));
    }

    /**
     * @covers Teknomavi\Common\Text::clear
     */
    public function testClear()
    {
        $this->assertEquals('Temiz bir metin', Text::clear(" Temiz  \n\r\n   bir     metin  &nbsp;   "));
    }

    /**
     * @covers Teknomavi\Common\Text::clear
     */
    public function testTrim()
    {
        $this->assertEquals("Temiz  \n\r\n   bir     metin", Text::trim(" Temiz  \n\r\n   bir     metin  &nbsp;   "));
    }

    /**
     * @covers Teknomavi\Common\Text::createSlug
     */
    public function testCreateSlug()
    {
        $this->assertEquals('eglenceli-bir-kategori-adi', Text::createSlug(' Eğlenceli bir kategori Adı   '));
    }

    /**
     * @covers Teknomavi\Common\Text::generateRandom
     */
    public function testGenerateRandom()
    {
        $this->assertTrue((bool) preg_match('@^[0-9a-f]{20}$@', Text::generateRandom(20)));
        $this->assertTrue((bool) preg_match('@^[0-9a-f]{68}$@', Text::generateRandom(68)));
    }
}
