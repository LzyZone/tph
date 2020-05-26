<?php

/**
* xml解析类
*/
class ParseXml
{

    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new parseXml();
        }
        return self::$instance;
    }

    /**
     * XML文档转为数组  
     * @param string $xml XML文档字符串  
     * @return array  
     */
    public static function xmlToArray($xml)
    {
        return $xml ? self::xmlToArrayElement(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)) : array();
    }

    /**
     * xml文档转为数组元素  
     * @param obj $xmlobject XML文档对象  
     * @return array  
     */
    public static function xmlToArrayElement($xmlobject)
    {
        $data = array();
        foreach ((array) $xmlobject as $key => $value) {
            $data[$key] = !is_string($value) ? self::xmlToArrayElement($value) : $value;
        }
        return $data;
    }

}
