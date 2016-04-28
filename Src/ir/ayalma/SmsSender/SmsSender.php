<?php

namespace ir\ayalma\SmsSender;


use Exception;
use MongoDB\Driver\Exception\ConnectionTimeoutException;

/**
 * Created by PhpStorm.
 * User: alimohammadi
 * Date: 4/18/16
 * Time: 6:47 PM
 */
class SmsSender
{
    /**
     * @var Config;
     */
    private $_config = null;

    /**
     * SmsSender constructor.
     * @param Config $_config configuration of SmsSender .
     */
    public function __construct(Config $_config)
    {
        $this->_config = $_config;
    }


    /**
     * @param Client $client
     * @param $mobile array : array of mobile number it must be smaller than 89.
     * @param $message : message for sending.
     * @param string $type : msg type related to @link {http://www.afe.ir/}
     * @return array|string : return array of messageIds or string for error result.
     */
    public function sendMessage(Client $client, $mobile, $message, $type = '')
    {
        
        $method = 'SendMessage';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'Number' => $this->_config->getNumber(),
            'Mobile' => array("$mobile"),
            'Message' => "$message",
            'Type' => "$type");


        /* if ($type == 'object')
             return get_object_vars($result);*/

        return $this->SendRequest($client, $method, $param);
    }

    /**
     * @param Client $client
     * @param $messageId : id of message that wide get to you.
     * @return string : status of message.
     * @throws Exception throw exception if connect method not call first.
     */
    public function getMessageStatus(Client $client, $messageId)
    {

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'SmsID' => "$messageId");

        $method = 'GetMessageStatus';

        return $this->SendRequest($client, $method, $param);

    }

    /**
     * @param $messagesId array of message id . array size must be < 10.
     * @param Client $client
     * @return array : array of status string.
     * @throws Exception : null error if connect method not call before this method.
     */
    public function getMessagesStatus($messagesId, Client $client)
    {

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'SmsID' => array("$messagesId"));

        $method = 'GetMessagesStatus';

        return $this->SendRequest($client, $method, $param);
    }

    /**
     * @return string : status as string..
     */
    function getRemainingCredit(Client $client)
    {
        $method = 'GetRemainingCredit';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword());

        return $this->SendRequest($client, $method, $param);

    }

    public function sendBusinessCard(Client $client, $mobiles, $contactName, $phoneNumber, $type = '')
    {
        $method = 'SendBusinessCard';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'Number' => $this->_config->getNumber(),
            'Mobile' => array("$mobiles"),
            'ContactName' => "$contactName",
            'PhoneNumber' => "$phoneNumber",
            'Type' => "$type");

        return $this->SendRequest($client, $method, $param);
    }

    public function sendWappush(Client $client, $mobiles, $url, $description, $type = '')
    {
        $method = 'SendWappush';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'Number' => $this->_config->getNumber(),
            'Mobile' => array("$mobiles"),
            'Url' => "$url", 'Description' => "$description", 'Type' => "$type");

        return $this->SendRequest($client, $method, $param);

    }

    public function getMessageId($client, $checkingMessageId)
    {
        $method = 'GetMessageID';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'CheckingMessageID' => "$checkingMessageId");

        return $this->SendRequest($client, $method, $param);
    }

    public function sendMessagePeerToPeer($client, $numbers, $mobiles, $types, $messages)
    {
        $method = 'SendMessagePeerToPeer';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'Number' => array("$numbers"),
            'Mobile' => array("$mobiles"),
            'Message' => array("$messages"),
            'Type' => array("$types"));

        return $this->SendRequest($client, $method, $param);
    }

    /**
     * @param Client $client
     * @param $mobile array : array of mobile number it must be smaller than 89.
     * @param $message : message for sending.
     * @param array(long) $checkingId
     * @param string $type : msg type related to @link {http://www.afe.ir/}
     * @return array|string : return array of messageIds or string for error result.
     */
    public function sendMessage7(Client $client, $mobile, $message, $checkingId, $type = '')
    {

        $method = 'SendMessage';

        $param = array('Username' => $this->_config->getUserName(),
            'Password' => $this->_config->getPassword(),
            'Number' => $this->_config->getNumber(),
            'Mobile' => array("$mobile"),
            'Message' => "$message",
            'Type' => "$type",
            'CheckingMessageID' => array("$checkingId"));


        /* if ($type == 'object')
             return get_object_vars($result);*/

        return $this->SendRequest($client, $method, $param);
    }

    /**
     * @param Client $client
     * @param $method
     * @param $param
     * @return mixed
     */
    private function SendRequest(Client $client, $method, $param)
    {
        try {
            $result = $client->getSoapClient()->__soapCall($method, array($param));

            $merge = $method . 'Result';

            if ($result->$merge->string != '')
                return $result->$merge->string;
            else
                return $result->$merge;
        }
        catch (ConnectionTimeoutException $e)
        {
            return 'TimeOut';
        }
    }

}