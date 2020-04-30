<?php

namespace App\Services;

use RandomLib;

/**
 * This Method will serve you to creating something. 
 * 
 * All Capabilities that are in this service, fully endowed by you.
 * 
 * @author Fachrurozi
 */
class CreationService
{
    /**
     * Awarded the ability to create random code.
     * 
     * @param int $length
     * @param string $characters
     * @return string
     */
    public function code($length, $characters)
    {
        $factory = new RandomLib\Factory;
        $generator = $factory->getMediumStrengthGenerator();
        $code = $generator->generateString($length, $characters);

        return $code;
        
    }

    /**
     * Awarded the ability to create Order ID from random Code
     * 
     * @param string $orderKey
     * @return String
     */
    public function orderId($orderKey){

        $orderId = $this->code(10, $orderKey."ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
        return $orderId;

    }

    /**
     * Awarded the ability to create payment code from random Code
     * 
     * @param string $orderKey
     * @return String
     */
    public function paymentCode($orderKey)
    {
        $orderId = $this->orderId($orderKey);
        $paymentCode = $this->code(12, $orderId."ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
        return "KRC".$paymentCode;
    }
    
}
