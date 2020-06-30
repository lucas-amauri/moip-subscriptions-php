<?php
namespace MoipSubscription\Resource;

use MoipSubscription\MoipSubscription;
use Scrap\Scrap;
use stdClass;
use JsonSerializable;

abstract class MoipResource extends Scrap  implements JsonSerializable {
    /**
     * @var \Moip\Moip
     */
    protected $moip;
            
    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * Create a new instance.
     *
     * @param \Moip\Moip $moip
     */
    public function __construct(MoipSubscription $moip)
    {
        $this->moip = $moip;
        $this->data = new stdClass();
        $this->initialize();
        
        $this->setHeaders([
            "Authorization: Basic " . base64_encode($this->moip->getToken() . ":" . $this->moip->getKey()),
            "Content-type: application/json"
        ]);
    }    
    
    protected function send($url, $method = "GET", $params = null) {
        $result = $this->sendRequest($this->moip->getEndpoint() . $url, $method, $this->data ? json_encode($this->data, true) : null);
        
        return json_decode($result, true);
    }
    
    protected function format_value($number) {
        return number_format($number * 100, 0, '', '');
    }
    
    public function jsonSerialize()
    {
        return $this->data;
    }
}