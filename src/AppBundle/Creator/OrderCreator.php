<?php

namespace AppBundle\Creator;

use AppBundle\Entity\Order;

class OrderCreator extends Creator
{
    private $values;

    private function toCamelCase($str) {
        $str[0] = strtoupper($str[0]);
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }

    public function create() {

        $order = new Order();

        foreach ($this->values as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToppingsToCommaString($value);
            }
            $method = "set" . $this->toCamelCase($key);
            if (is_callable([$order, $method])) {
                $order->{$method}($value);
            } else {
                return "Invalid Key: ${key}.";
            }
        }

        return $order;
    }

    private function convertToppingsToCommaString(array $toppings): string
    {
        return implode(",", $toppings);
    }
}