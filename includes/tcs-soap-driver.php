<?php
/**
 * Created by IntelliJ IDEA.
 * User: frt
 * Date: 7/7/17
 * Time: 4:08 PM
 */

//sudo apt install php7.0
//sudo apt install php7.0-dev
//php-config --configure-options --enable-soap
//sudo apt-get install php7.0-soap
//sudo apt-get install php7.0-xml
class GetAllCountriesResult{
    public $schema;
    /**
     * GetAllCountriesResult constructor.
     */
}
class GetAllCountriesResponse{
}
class GetAllCitiesResult{
    public $schema;
    /**
     * GetAllCountriesResult constructor.
     */
}
class GetAllCitiesResponse{
}
class GetAllOriginCitiesResult{
    public $schema;
    /**
     * GetAllCountriesResult constructor.
     */
}
class GetAllOriginCitiesResponse{
}
class GetCNDetailsByReferenceNumberResult{
    public $schema;
    /**
     * GetAllCountriesResult constructor.
     */
}
class GetCNDetailsByReferenceNumberResponse{
}
class InsertDataResult{
    /**
     * GetAllCountriesResult constructor.
     */
}
class InsertDataResponse{
}




class  TcsAPI{

    private $option;
    private $client;
    /**
     * TcsAPI constructor.
     */
    public function __construct()
    {
        $this->option = array('trace' => 1,
            'soap_version' => SOAP_1_2,
            'classmap' => array('GetAllCountriesResponse'=>'GetAllCountriesResponse',
                'GetAllCountriesResult' => 'GetAllCountriesResult',
                'GetAllCitiesResponse' => 'GetAllCitiesResponse',
                'GetAllCitiesResult' => 'GetAllCitiesResult',
                'GetAllOriginCitiesResponse' => 'GetAllOriginCitiesResponse',
                'GetAllOriginCitiesResult' => 'GetAllOriginCitiesResult',
                'GetCNDetailsByReferenceNumberResponse' => 'GetCNDetailsByReferenceNumberResponse',
                'GetCNDetailsByReferenceNumberResult' => 'GetCNDetailsByReferenceNumberResult',
                'InsertDataResponse' => 'InsertDataResponse',
                'InsertDataResult' => 'InsertDataResult',
            )
        );
        $this->client = new SoapClient("http://webapp.tcscourier.com/codapi/Service1.asmx?WSDL",$this->option);
    }

    public function createBooking($entry=array()){
//      [TODO]  Please don't call below code otherwise it will create an entry in live system.

        $response = $this->client->InsertData($entry);
        return $response->InsertDataResult;
//        return "000000000"; // example tracking code
    }

    public function GetAllCities(){
        $response=$this->client->GetAllCities();
        return $response;
    }
}
//InsertDataResponse Object
//(
//    [InsertDataResult] => 77430100044
//)

//$tcsapi=new TcsAPI();
//
//$response=$tcsapi->GetAllCities();
?>