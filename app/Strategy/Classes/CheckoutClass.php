<?php

namespace App\Strategy\Classes;
use  App\Strategy\Interfaces\PaymentStrategyInterface;

class CheckoutClass implements PaymentStrategyInterface {

    public function pay($data) {
        return [
            'data' => $data,
            'class' => 'CheckoutClass'
        ];
    }

}
