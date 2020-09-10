<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Model;

/**
 * Genome User class.
 *
 * @mixin \OxidEsales\Eshop\Application\Model\User
 */
class User extends User_parent
{
    /**
     * Retrieve User details.
     * @return array
     */
    public function getDetails(): array
    {
        $details = [
            'customer_id' => $this->oxuser__oxcustnr->value,
            'email' => $this->oxuser__oxusername->value,
            'firstname' => $this->oxuser__oxfname->value,
            'lastname' => $this->oxuser__oxlname->value,
            'address' => $this->oxuser__oxstreet->value . ' ' . $this->oxuser__oxstreetnr->value,
            'city' => $this->oxuser__oxcity->value,
            'zip' => $this->oxuser__oxzip->value,
            'country' => $this->oxuser__oxcountry->value,
            'phone' => $this->oxuser__oxfon->value,
        ];
        
        return $details;
    }
}
