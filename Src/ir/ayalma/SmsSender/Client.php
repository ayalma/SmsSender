<?php
/**
 * class that handles different type of afe.ir webservice urls.
 * Created by PhpStorm.
 * User: AliMohammadi
 * Date: 4/22/16
 * Time: 12:25 PM
 */

namespace ir\ayalma\SmsSender;


use Exception;
use SoapClient;

class Client
{
    /**
     * @var int
    */
    private $_version;
    /**
     * @var SoapClient
     */
    private $_soapClient;

   
    public function __construct($_version)
    {
        $this->_version = $_version;
        switch ($_version)
        {
            case 1:
                $this->_soapClient = new SoapClient('http://www.afe.ir/WebService/webservice.asmx?WSDL');
                break;
            case 4:
                $this->_soapClient = new SoapClient('http://www.afe.ir/WebService/V4/BoxService.asmx?WSDL');
                break;
            case 5:
                $this->_soapClient = new SoapClient('http://www.afe.ir/WebService/V5/BoxService.asmx?WSDL');
                break;
            case 7:
                $this->_soapClient = new SoapClient('http://www.afe.ir/WebService/V7/BoxService.asmx?WSDL');
                break;
            default:
                throw new Exception('version type must be one of 1 , 5 , 4 , 7');
        }
        
    }

    /**
     * @return SoapClient
     */
    public function getSoapClient()
    {
        return $this->_soapClient;
    }

    /**
     * @param SoapClient $soapClient
     */
    public function setSoapClient($soapClient)
    {
        $this->_soapClient = $soapClient;
    }
    
    


}