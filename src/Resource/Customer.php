<?php
namespace Moip\Resource;

use stdClass;

class Customer extends MoipResource {
    protected function initialize() {
        $this->data = new stdClass();
        $this->data->code = null;
        $this->data->fullname = null;
        $this->data->email = null;
        $this->data->phone_area_code = null;
        $this->data->phone_number = null;
        $this->data->birthdate_day = null;
        $this->data->birthdate_month = null;
        $this->data->birthdate_year = null;
        $this->data->cpf = null;
        $this->data->address = new stdClass();
        $this->data->address->street = null;
        $this->data->address->number = null;
        $this->data->address->complement = null;
        $this->data->address->district = null;
        $this->data->address->city = null;
        $this->data->address->state = null;
        $this->data->address->zipcode = null;
        $this->data->address->country = null;
        $this->data->billing_info = new stdClass();
        $this->data->billing_info->credit_card = new stdClass();
        $this->data->billing_info->credit_card->holder_name = null;
        $this->data->billing_info->credit_card->number = null;
        $this->data->billing_info->credit_card->expiration_month = null;
        $this->data->billing_info->credit_card->expiration_year = null;
    }
    
    /**
     * Set Own id from customer.
     *
     * @param string $ownId Customer's own id. external reference.
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->data->code = $code;

        return $this;
    }
    
    public function getCode() {
        return $this->data->code;
    }

    /**
     * Set fullname from customer.
     *
     * @param string $fullname Customer's full name.
     *
     * @return $this
     */
    public function setFullname($fullname)
    {
        $this->data->fullname = $fullname;

        return $this;
    }

    /**
     * Set e-mail from customer.
     *
     * @param string $email Email customer.
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->data->email = $email;

        return $this;
    }

    public function addAddress($type, $street, $number, $district, $city, $state, $zip, $complement = null)
    {
        $address = new stdClass();
        $address->street = $street;
        $address->number = $number;
        $address->complement = $complement;
        $address->district = $district;
        $address->city = $city;
        $address->state = $state;
        $address->country = "BRA";
        $address->zipcode = str_replace("-", "", $zip);
        
        $this->data->address = $address;

        return $this;
    }
    
    /**
     * Set birth date from customer.
     *
     * @param \DateTime|string $birthDate Date of birth of the credit card holder.
     *
     * @return $this
     */
    public function setBirthDate($birthDate)
    {
        if ($birthDate instanceof \DateTime) {
            $birthDate = $birthDate->format('Y-m-d');
        }
        
        $intDate = strtotime($birthDate);

        $this->data->birthdate_day = date("d", $intDate);
        $this->data->birthdate_month = date("m", $intDate);
        $this->data->birthdate_year = date("Y", $intDate);

        return $this;
    }
    
    /**
     * Set tax document from customer.
     *
     * @param string $number Document number.
     * @param string $type   Document type.
     *
     * @return $this
     */
    public function setTaxDocument($number)
    {
        $this->data->cpf = str_replace([".", "-"], "", $number);
        return $this;
    }

    /**
     * Set phone from customer.
     *
     * @param int $areaCode    DDD telephone.
     * @param int $number      Telephone number.
     * @param int $countryCode Country code.
     *
     * @return $this
     */
    public function setPhone($areaCode, $number, $countryCode = 55)
    {
        $this->data->phone_area_code = $areaCode;
        $this->data->phone_number = $number;

        return $this;
    }
    
    /**
     * Set Customer Credit card Billing info
     * @param string $holder_name
     * @param double $card_number
     * @param int $expiration_month
     * @param int $expiration_year
     */
    public function setBillingInfo($holder_name, $card_number, $expiration_month, $expiration_year) {
        $this->data->billing_info->credit_card->holder_name = $holder_name;
        $this->data->billing_info->credit_card->number = str_replace([".", " ", "-"], "", $card_number);
        $this->data->billing_info->credit_card->expiration_month = $expiration_month;
        $this->data->billing_info->credit_card->expiration_year = $expiration_year;
        
        return $this;
    }
    
    public function getBillingInfo() {
        return $this->data->billing_info;
    }
    
    public function populate() {
        return $this->data;
    }

    public function create() {
        $new_vault = "true";
        return $this->send("/assinaturas/v1/customers?new_vault=" . $new_vault, "POST");
    }
    
    /**
     * Get a customer
     * @param string $code Customer code
     * @return array
     */
    public function get($code) {
        return $this->send('/assinaturas/v1/customers/' . $code, "GET");
    }
    
    /**
     * Get customer list
     * @return array
     */
    public function getList() {
        return $this->send('/assinaturas/v1/customers', "GET");
    }
    
    /**
     * 
     * @param string $code
     * @return boolean
     */
    public function search($code) {
        $arrCustomers = $this->getList();

        foreach ($arrCustomers["customers"] as $customer) {
            if ($customer["code"] == $code) {
                return $customer;
            }
        }

        return false;
    }
}