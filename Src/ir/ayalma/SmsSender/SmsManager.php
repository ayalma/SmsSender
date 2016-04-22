<?php
/**
 * Created by PhpStorm.
 * User: alimohammadi
 * Date: 4/22/16
 * Time: 12:25 PM
 */

namespace ir\ayalma\SmsSender;


class SmsManager
{
    private static $_instance;
    /**
     * @var SmsSender
     */
    private $smsSender;
    /**
     * @var Config
     */
    private $config;
    private $_clients;

    /**
     * SmsManager constructor.
     */
    private function __construct()
    {
        $this->_clients = array(1 => new Client(1),
            4 => new Client(4),
            5 => new Client(5),
            7 => new Client(7));
    }

    public static function getInstance()
    {
        if (self::$_instance == null)
            self::$_instance = new SmsManager();
        return self::$_instance;
    }

    public function init(Config $config)
    {
        $this->config = $config;
        $this->smsSender = new SmsSender($config);
    }

    /**
     * all method for v1 webservice.
     */

    /**
     *
     */
    public function getRemainingCreditV1()
    {
        return $this->smsSender->getRemainingCredit($this->_clients[1]);
    }

    public function SendMessageV1($mobile, $message, $type)
    {
        return $this->smsSender->sendMessage($this->_clients[1], $mobile, $message, $type);
    }

    /**
     * all method for v4 webservice.
     */

    public function sendBusinessCardV4()
    {

    }

    public function SendMessageV4($mobile, $message, $type)
    {
        return $this->smsSender->sendMessage($this->_clients[4], $mobile, $message, $type);
    }

    public function sendWappushV4($mobile, $message, $type)
    {
        return $this->smsSender->sendWappush($this->_clients[4], $mobile, $message, $type);
    }

    /**
     * all method for v5 webservice.
     */

    /**
     * @param $messageId
     * @return array
     * @throws \Exception
     */
    public function GetMessageStatusV5($messageId)
    {
        return $this->smsSender->getMessagesStatus($messageId, $this->_clients[5]);
    }

    public function GetMessagesStatusV5($messagesId)
    {
        return $this->smsSender->getMessagesStatus($messagesId, $this->_clients[5]);
    }

    public function SendMessageV5($mobile, $message, $type)
    {
        return $this->smsSender->sendMessage($this->_clients[5], $mobile, $message, $type);
    }

    /**
     * all method for v7 webservice.
     */

    public function getMessageStatusV7($messageId)
    {
        return $this->smsSender->getMessagesStatus($messageId, $this->_clients[7]);
    }

    public function getMessagesStatusV7($messagesId)
    {
        return $this->smsSender->getMessagesStatus($messagesId, $this->_clients[7]);
    }

    /**
     * @param $mobile : destination user mob number.
     * @param $message : msg for send.
     * @param $type : type of sending : for more info go to @link{afe.ir};
     * @param $checkingId : this id will be resent to you if afe receive your request.
     * @return array|string: status of sending.
     */
    public function sendMessageV7($mobile, $message, $checkingId, $type)
    {
        return $this->smsSender->sendMessage7($this->_clients[7], $mobile, $message, $checkingId, $type);
    }

    /**
     * @param $checkingId : check id that afe send to user.
     * @return mixed : id of message or error string.
     */
    public function getMessageIdV7($checkingId)
    {
        return $this->smsSender->getMessageId($this->_clients[7], $checkingId);
    }

    /**
     * @return int : integer contains remaining value of account.
     */
    public function getRemainingCreditV7()
    {
        return $this->smsSender->getRemainingCredit($this->_clients[7]);
    }

    /**
     * @param array $numbers : array of number for sending sms
     * @param array $mobiles : array of mobile will receive sms
     * @param array $types : array of type for each sms.
     * @param array $messages : array of message for send to users.
     * @return array         : status of sending.
     */
    public function sendMessagePeerToPeer($numbers, $mobiles, $types, $messages)
    {
        return $this->smsSender->sendMessagePeerToPeer($this->_clients[7], $numbers, $mobiles, $types, $messages);
    }


}