<?php
namespace Moip;

use Moip\Resource\Plan;
use Moip\Resource\Customer;
use Moip\Resource\Subscription;
use Moip\Resource\Invoice;
use Scrap\Scrap;

class Moip {
    /**
     * endpoint of production.
     *
     * @const string
     */
    const ENDPOINT_PRODUCTION = 'https://api.moip.com.br';

    /**
     * endpoint of sandbox.
     *
     * @const string
     */
    const ENDPOINT_SANDBOX = 'https://sandbox.moip.com.br';
    
    /**
     * Endpoint of request.
     *
     * @var \Moip\Moip::ENDPOINT_PRODUCTION|\Moip\Moip::ENDPOINT_SANDBOX
     */
    private $endpoint;
    
    private $token;
    
    private $key;
    
    /**
     * 
     * @param String $token
     * @param String $key
     * @param String $endpoint
     */    
    public function __construct($token, $key, $endpoint = self::ENDPOINT_SANDBOX)
    {        
        $this->endpoint = $endpoint;
        $this->token = $token;
        $this->key = $key;
    }
    
    public function plan() {
        return new Plan($this);
    }
    
    public function customer() {
        return new Customer($this);
    }
    
    public function subscription() {
        return new Subscription($this);
    }
    
    public function invoice() {
        return new Invoice($this);
    }

    public function getEndpoint() {
        return $this->endpoint;
    }
    
    public function getToken() {
        return $this->token;
    }
    
    public function getKey() {
        return $this->key;
    }
}
