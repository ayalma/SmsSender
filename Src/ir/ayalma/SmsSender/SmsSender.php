<?php

namespace ir\ayalma\SmsSender;


use Exception;
use SoapClient;

/**
 * Created by PhpStorm.
 * User: alimohammadi
 * Date: 4/18/16
 * Time: 6:47 PM
 */
class SmsSender
{
    private static $_instance = null;

    /**
     * @var Config;
     */
    private $_config = null;
    private $_client;

    /**
     * SmsSender constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return SmsSender|null : return singleton instance of SmsSender.
     */
    public static function getInstance()
    {
        if (self::$_instance == null)
            self::$_instance = new SmsSender();
        return self::$_instance;
    }

    /**
     *
     * @param Config $config : configuration of SmsSender . call this method just one time in code.
     */
    public function init(Config $config)
    {
        $this->_config = $config;
    }

    /**
     * connect to webservice.
     * @throws Exception if config is null.
     */
    public function connect()
    {
        if ($this->_config == null)
            throw new Exception('config is null , pleas call init first');

        ini_set("soap.wsdl_cache_enabled", "0");
        $this->_client = new SoapClient($this->_config->getUrl());
    }

    /**
     * @param $mobile array : array of mobile number it must be smaller than 89.
     * @param $message : message for sending.
     * @param string $type : msg type related to @link {http://www.afe.ir/}
     * @return mixed
     * @throws Exception : throw exception if connect method not call first.
     */
    public function sendMessage($mobile, $message, $type = '')
    {

        if ($this->_client == null)
            throw new Exception('client is null . pls call connect method first');

        $method = 'SendMessage';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'Number' => $this->_config->getNumber(),
            'Mobile' => array("$mobile"),
            'Message' => "$message",
            'Type' => "$type");


        $result = $this->_client->__SoapCall($method, array($param));


        if ($type == 'object')
            return get_object_vars($result);

        $merge = $method . 'Result';

        if ($result->$merge->string != '')
            return $result->$merge->string;
        else
            return $result->$merge;
    }

    /**
     * @param $massageId : id of message that wide get to you.
     * @return mixed status of message.
     * @throws Exception throw exception if connect method not call first.
     */
    public function getMessageStatus($massageId)
    {

        if ($this->_client == null)
            throw new Exception('client is null . pls call connect method first');

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'SmsID' => "$massageId");

        $method = 'GetMessageStatus';

        $result = $this->_client->__SoapCall($method, array($param));

        $merge = $method . 'Result';
        if ($result->$merge->string != '')
            return $result->$merge->string;
        else
            return $result->$merge;

    }


}