<?php
namespace Moip\Resource;

use stdClass;

class Invoice extends MoipResource {
    protected function initialize() {
        $this->data = new stdClass();
    }
    
    /**
     * Get a invoice
     * @param string $code Invoice id
     * @return array
     */
    public function get($id) {
        return $this->send('/assinaturas/v1/invoices/' . $code, "GET");
    }
    
    /**
     * Get invoice list
     * @param string $code Subscription code
     * @return array
     */
    public function getList($code) {
        return $this->send('/assinaturas/v1/subscriptions/' . $code . '/invoices', "GET");
    }
}