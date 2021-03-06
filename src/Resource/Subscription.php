<?php
namespace MoipSubscription\Resource;

use MoipSubscription\Resource\Customer;
use stdClass;

class Subscription extends MoipResource {
    protected function initialize() {
        $this->data = new stdClass();
        $this->data->code = null;
        $this->data->payment_method = null;
        $this->data->customer = null;
        $this->data->plan = new stdClass();
        $this->data->plan->code = null;
    }
    
    public function setCode($code) {
        $this->data->code = $code;
        return $this;
    }
    
    public function setPlan($code) {
        $this->data->plan->code = $code;
        return $this;
    }
    
    public function setPaymentMethod($payment_method) {
        $this->data->payment_method = $payment_method;
        return $this;
    }
    
    public function setCustomer(Customer $customer) {
        $this->data->customer = $customer;
        return $this;
    }
    
    public function create() {
        if (!$this->data->customer) {
            throw new Exception("No client defined");
        }
        
        $customer_code = $this->data->customer->getCode();
        
        $customer_data = $this->data->customer->search($this->data->customer->getCode());

        if ($customer_data) {            
            $customer_code = $customer_data["code"];
            
            if ($customer_data["billing_info"]) {
                //$this->data->billing_info->credit_card->vault = $customer_data["billing_info"]["credit_cards"][0]["vault"];
            }
        }
        else {
            $create_cliente = $this->data->customer->create();

            if (isset($create_cliente["errors"])) {
                throw new \Exception(json_encode($create_cliente["errors"]));
            }
        }
        $this->data->customer = $this->data->customer->populate();
        
        if (!$this->data->customer->billing_info->credit_card->number) {
            unset($this->data->customer->billing_info);
        }

        $response = $this->send("/assinaturas/v1/subscriptions?new_customer=false", "POST");
        
        if (@($response["errors"])) {
            throw new \Exception(json_encode($response["errors"]));
        }
        
        return $response;
    }
    
    public function update($code) {
        unset($this->data->code);
        unset($this->data->customer);
        unset($this->data->payment_method);       
        
        $response = $this->send("/assinaturas/v1/subscriptions/" . $code, "PUT");
        
        if (@($response["errors"])) {
            throw new \Exception(json_encode($response["errors"]));
        }
        
        return $response;
    }
    
    public function suspend($code) {
        $this->data = null;
        $response = $this->send("/assinaturas/v1/subscriptions/" . $code . "/suspend", "PUT");
        
        if (@($response["errors"])) {
            throw new \Exception(json_encode($response["errors"]));
        }
        
        return $response;
    }
    
    public function activate($code) {
        $this->data = null;
        $response = $this->send("/assinaturas/v1/subscriptions/" . $code . "/activate", "PUT");
        
        if (@($response["errors"])) {
            throw new \Exception(json_encode($response["errors"]));
        }
        
        return $response;
    }
    
    public function change_payment_method($code) {
        unset($this->data->code);
        unset($this->data->customer);
        unset($this->data->plan);       
        
        $response = $this->send("/assinaturas/v1/subscriptions/" . $code . "/change_payment_method", "PUT");
        
        if (@($response["errors"])) {
            throw new \Exception(json_encode($response["errors"]));
        }
        
        return $response;
    }
    
    public function cancel($code) {
        $this->data = null;
        $response = $this->send("/assinaturas/v1/subscriptions/" . $code . "/cancel", "PUT");
        
        if (@($response["errors"])) {
            throw new \Exception(json_encode($response["errors"]));
        }
        
        return $response;
    }
    
    public function get($code) {
        return $this->send("/assinaturas/v1/subscriptions/" . $code);
    }
    
    public function getList() {
        return $this->send('/assinaturas/v1/subscriptions', "GET");
    }
}