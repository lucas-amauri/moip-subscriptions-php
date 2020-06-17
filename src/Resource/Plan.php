<?php
namespace Moip\Resource;

use stdClass;

class Plan extends MoipResource {
    protected function initialize() {
        $this->data = new stdClass();
        $this->data->code = null;
        $this->data->name = null;
        $this->data->description = null;
        $this->data->amount = null;
        $this->data->payment_method = "ALL";
        $this->data->interval = new stdClass();
        $this->data->interval->length = null;
        $this->data->interval->unit = null;
    }
    
    public function setName($name) {
        $this->data->name = $name;
        return $this;
    }
    
    public function setDescription($description) {
        $this->data->description = $description;
        return $this;
    }
    
    public function setCode($code) {
        $this->data->code = $code;
        return $this;
    }
    
    public function setAmount($amount) {
        $this->data->amount = $this->format_value($amount);
        return $this;
    }
    
    public function create() {
        return $this->send("/assinaturas/v1/plans", "POST");
    }
    
    public function update() {
        return $this->send("/assinaturas/v1/plans", "PUT");
    }
    
    public function get($code) {
        return $this->send('/assinaturas/v1/plans/' . $code, "GET");
    }
    
    public function getList() {
        return $this->send('/assinaturas/v1/plans', "GET");
    }
}