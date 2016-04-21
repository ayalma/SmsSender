<?php
/**
 * Created by PhpStorm.
 * User: alimohammadi
 * Date: 4/21/16
 * Time: 7:32 PM
 */
namespace ir\ayalma\SmsSender;


class Config
{
    private $_url;
    private $_userName;
    private $_password;
    private $_number;

    /**
     * Config constructor.
     * @param $_url : url of sms webservice.
     * @param $_userName : username of user in webservice
     * @param $_password : password of user.
     * @param $_number   : phone number that sms sender give to you.
     */
    public function __construct($_url, $_userName, $_password, $_number)
    {
        $this->_url = $_url;
        $this->_userName = $_userName;
        $this->_password = $_password;
        $this->_number = $_number;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->_userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->_number = $number;
    }
    
    


}