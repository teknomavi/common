<?php
/**
 * Array2XML: A class to convert array in PHP to XML
 * It also takes into account attributes names unlike SimpleXML in PHP
 * It returns the XML in form of DOMDocument class for further manipulation.
 * It throws exception if the tag name or attribute name has illegal chars.
 * Author : Lalit Patel
 * Website: http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes
 * License: Apache License 2.0
 *          http://www.apache.org/licenses/LICENSE-2.0
 * Version: 0.1 (10 July 2011)
 * Version: 0.2 (16 August 2011)
 *          - replaced htmlentities() with htmlspecialchars() (Thanks to Liel Dulev)
 *          - fixed a edge case where root node has a false/null/0 value. (Thanks to Liel Dulev)
 * Version: 0.3 (22 August 2011)
 *          - fixed tag sanitize regex which didn't allow tagnames with single character.
 * Version: 0.4 (18 September 2011)
 *          - Added support for CDATA section using @cdata instead of @value.
 * Version: 0.5 (07 December 2011)
 *          - Changed logic to check numeric array indices not starting from 0.
 * Version: 0.6 (04 March 2012)
 *          - Code now doesn't @cdata to be placed in an empty array
 * Version: 0.7 (24 March 2012)
 *          - Reverted to version 0.5
 * Version: 0.8 (02 May 2012)
 *          - Removed htmlspecialchars() before adding to text node or attributes.
 * Usage:
 *       $xml = Array2XML::createXML('root_node_name', $php_array);
 *       echo $xml->saveXML();
 */
namespace Teknomavi\Common;

use \DOMDocument;
use \Exception;

class Array2XML
{
    /**
     * @var DomDocument
     */
    private $xml = null;
    /**
     * @var string
     */
    private $encoding = 'UTF-8';

    /**
     * Initialize the root XML node [optional]
     * @param string $version
     * @param string $encoding
     * @param bool $format_output
     */
    public function init($version = '1.0', $encoding = 'UTF-8', $format_output = true)
    {
        $this->xml = new DOMDocument($version, $encoding);
        $this->xml->formatOutput = $format_output;
        $this->encoding = $encoding;
    }

    /**
     * Convert an Array to XML
     * @param string $node_name - name of the root node to be converted
     * @param array $data - aray to be converterd
     * @return DomDocument
     */
    public function &createXML($node_name, $data = array())
    {
        $xml = $this->getXMLRoot();
        $xml->appendChild($this->convert($node_name, $data));
        $this->xml = null;    // clear the xml node in the class for 2nd time use.
        return $xml;
    }

    /**
     * Convert an Array to XML
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @throws \Exception
     * @return \DOMNode
     */
    private function &convert($node_name, $arr = array())
    {
        $xml = $this->getXMLRoot();
        $node = $xml->createElement($node_name);
        if (is_array($arr)) {
            // get the attributes first.;
            if (isset($arr['@attributes'])) {
                foreach ($arr['@attributes'] as $key => $value) {
                    if (!$this->isValidTagName($key)) {
                        throw new Exception('[Array2XML] Illegal character in attribute name. attribute: ' . $key . ' in node: ' . $node_name);
                    }
                    $node->setAttribute($key, $this->boolString($value));
                }
                unset($arr['@attributes']);
            }
            // check if it has a value stored in @value, if yes store the value and return else check if its directly stored as string
            if (isset($arr['@value'])) {
                $node->appendChild($xml->createTextNode($this->boolString($arr['@value'])));
                unset($arr['@value']);
                return $node;
            } else {
                if (isset($arr['@cdata'])) {
                    $node->appendChild($xml->createCDATASection($this->boolString($arr['@cdata'])));
                    unset($arr['@cdata']);
                    return $node;
                }
            }
        }
        //create subnodes using recursion
        if (is_array($arr)) {
            // recurse to get the node for that key
            foreach ($arr as $key => $value) {
                if (!$this->isValidTagName($key)) {
                    throw new Exception('[Array2XML] Illegal character in tag name. tag: ' . $key . ' in node: ' . $node_name);
                }
                if (is_array($value) && is_numeric(key($value))) {
                    // MORE THAN ONE NODE OF ITS KIND
                    // if the new array is numeric index, means it is array of nodes of the same kind
                    // it should follow the parent key name
                    foreach ($value as $k => $v) {
                        $node->appendChild($this->convert($key, $v));
                    }
                } else {
                    // ONLY ONE NODE OF ITS KIND
                    $node->appendChild($this->convert($key, $value));
                }
                unset($arr[$key]); //remove the key from the array once done.
            }
        }
        // after we are done with all the keys in the array (if it is one)
        // we check if it has any text value, if yes, append it.
        if (!is_array($arr) && $arr !== "") {
            $node->appendChild($xml->createTextNode($this->boolString($arr)));
        }
        return $node;
    }

    /**
     * Get the root XML node, if there isn't one, create it.
     * @return DomDocument
     */
    private function getXMLRoot()
    {
        if (empty($this->xml)) {
            $this->init();
        }
        return $this->xml;
    }

    /**
     * Get string representation of boolean value
     * @param $v
     * @return string
     */
    private function boolString($v)
    {
        if ($v === true) {
            return "true";
        }
        if ($v === false) {
            return "false";
        }
        return $v;
    }

    /**
     * Check if the tag name or attribute name contains illegal characters
     * Ref: http://www.w3.org/TR/xml/#sec-common-syn
     * @param $tag
     * @return bool
     */
    private function isValidTagName($tag)
    {
        $pattern = '/^[a-z_]+[a-z0-9\:\-\.\_]*[^:]*$/i';
        return preg_match($pattern, $tag, $matches) && $matches[0] == $tag;
    }
}
