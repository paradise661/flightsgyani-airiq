<?php

namespace App\Service;


class XMLSerializer
{
    // functions adopted from http://www.sean-barton.co.uk/2009/03/turning-an-array-or-object-into-xml-using-php/

    public static function generateValidXmlFromArray($array, $node_block = 'nodes', $node_name = 'node')
    {
        $xml = self::generateXmlFromArray($array, $node_name);
        return $xml;
    }

    private static function generateXmlFromArray($array, $node_name)
    {
        $xml = '';

        if ((is_array($array) || is_object($array))) {
            foreach ($array as $key => $value) {
                if (is_numeric($key)) {
                    $key = $node_name;
                }
                if ($key != '_namespace' && $key != '_attributes' && $key != '_value') {
                    $xml .= '<' . $key . self::generateAttributesFromArray($value)
                        . self::generateNamespace($value)
                        . '>'
                        . self::generateXmlFromArray($value, $node_name) . '</' . $key . '>';
                }
                if ($key == '_value') {
                    $xml = htmlspecialchars($value, ENT_QUOTES);
                }
            }
        } else {
            $xml = htmlspecialchars($array, ENT_QUOTES);
        }

        return $xml;
    }

    private static function generateAttributesFromArray($array)
    {
        if (isset($array['_attributes']) && is_array($array['_attributes'])) {

            $attributes = ' ';
            foreach ($array['_attributes'] as $key => $value) {
                $attributes .= $key . '="' . $value . '" ';
            }
            return $attributes;
        } else {
            return '';
        }
    }

    private static function generateNamespace($namespace)
    {
        if (isset($namespace['_namespace']) && $namespace['_namespace']) {
            return ' xmlns="' . $namespace['_namespace'] . '"';
        } else {
            return '';
        }
    }


    /**
     * Convert XML to an Array
     *
     * @param string $XML
     * @return array
     */
    public static function XMLtoArray($XML)
    {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $XML, $vals);
        xml_parser_free($xml_parser);
        $xml_array = null;
        $_tmp = '';
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ($x_level != 1 && $x_type == 'close') {
                if (isset($multi_key[$x_tag][$x_level]))
                    $multi_key[$x_tag][$x_level] = 1;
                else
                    $multi_key[$x_tag][$x_level] = 0;
            }
            if ($x_level != 1 && $x_type == 'complete') {
                if ($_tmp == $x_tag)
                    $multi_key[$x_tag][$x_level] = 1;
                $_tmp = $x_tag;
            }
        }
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ($x_type == 'open')
                $level[$x_level] = $x_tag;
            $start_level = 1;
            $php_stmt = '$xml_array';
            if ($x_type == 'close' && $x_level != 1)
                $multi_key[$x_tag][$x_level]++;
            while ($start_level < $x_level) {
                $php_stmt .= '[$level[' . $start_level . ']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                    $php_stmt .= '[' . ($multi_key[$level[$start_level]][$start_level] - 1) . ']';
                $start_level++;
            }
            $add = '';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type == 'open' || $x_type == 'complete')) {
                if (!isset($multi_key2[$x_tag][$x_level]))
                    $multi_key2[$x_tag][$x_level] = 0;
                else
                    $multi_key2[$x_tag][$x_level]++;
                $add = '[' . $multi_key2[$x_tag][$x_level] . ']';
            }
            if (isset($xml_elem['value']) && trim($xml_elem['value']) != '' && !array_key_exists('attributes', $xml_elem)) {
                if ($x_type == 'open')
                    $php_stmt_main = $php_stmt . '[$x_type]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                else
                    $php_stmt_main = $php_stmt . '[$x_tag]' . $add . ' = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }
            if (array_key_exists('attributes', $xml_elem)) {
                if (isset($xml_elem['value'])) {
                    $php_stmt_main = $php_stmt . '[$x_tag]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }
                foreach ($xml_elem['attributes'] as $key => $value) {
                    $php_stmt_att = $php_stmt . '[$x_tag]' . $add . '[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }
        return $xml_array;
    }


}
