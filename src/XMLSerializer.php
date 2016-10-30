<?php
namespace Teknomavi\Common;

/**
 * Class XMLSerializer
 * adopted from http://www.sean-barton.co.uk/2009/03/turning-an-array-or-object-into-xml-using-php/.
 */
class XMLSerializer
{
    public static function generateValidXmlFromObj(\stdClass $obj, $node_block = 'nodes', $node_name = 'node')
    {
        $arr = get_object_vars($obj);

        return self::generateValidXmlFromArray($arr, $node_block, $node_name);
    }

    /**
     * @param array        $array     XML'e dönüştürülecek dizi
     * @param string       $nodeBlock En dıştaki boğum için kullanılacak isim
     * @param string|array $nodeNames Alt boğumlar için kullanılacak isimler.
     *
     * @return string
     */
    public static function generateValidXmlFromArray($array, $nodeBlock = 'nodes', $nodeNames = [])
    {
        if (is_string($nodeNames)) {
            $nodeNames = ['__global' => $nodeNames];
        }
        if (!isset($nodeNames['__global'])) {
            $nodeNames['__global'] = current($nodeNames);
        }
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $xml .= '<' . $nodeBlock . '>';
        $xml .= self::generateXmlFromArray($array, $nodeNames, $nodeBlock);
        $xml .= '</' . $nodeBlock . '>';

        return $xml;
    }

    private static function generateXmlFromArray($array, $nodeNames, $parentNodeName = '')
    {
        if (is_array($array) || is_object($array)) {
            $xml = '';
            foreach ($array as $key => $value) {
                if (is_numeric($key)) {
                    if (!empty($parentNodeName) && isset($nodeNames[$parentNodeName])) {
                        $key = $nodeNames[$parentNodeName];
                    } else {
                        $key = $nodeNames['__global'];
                    }
                }
                $xml .= '<' . $key . '>' . self::generateXmlFromArray($value, $nodeNames, $key) . '</' . $key . '>';
            }
        } else {
            $xml = htmlspecialchars($array, ENT_QUOTES);
        }

        return $xml;
    }
}
