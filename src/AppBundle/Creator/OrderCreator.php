<?php

namespace AppBundle\Creator;

use AppBundle\Entity\Order;

class OrderCreator extends Creator
{
    /**
     * OrderCreator constructor.
     *
     * Set the entity you want to have created
     *
     * I could have done this the usual route of DI, by typehinting Order, however where I access the class, like in the repository, I don't have access to the container, so this is the best route
     *
     * I could maneuver around this by doing this creation in the controller and passing the entity to the repository, but I don't like doing stuff like that in controllers. I want to leave data specific stuff to the repository layer
     */
    public function __construct()
    {
        $this->entity = new Order();
    }

    /**
     * Converts snake_case to camelCase
     *
     * @param $str
     * @return mixed
     */
    private function toCamelCase($str)
    {
        $str[0] = strtoupper($str[0]);
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }

    public function create()
    {
        foreach ($this->getValues() as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToppingsToCommaString($value);
            }
            $method = "set" . $this->toCamelCase($key);
            if (is_callable([$this->entity, $method])) {
                $this->entity->{$method}($value);
            } else {
                return "Invalid Key: ${key}.";
            }
        }

        return $this->entity;
    }

    /**
     * Takes an array and joins the elements
     *
     * @param array $toppings
     * @return string
     */
    private function convertToppingsToCommaString(array $toppings): string
    {
        return implode(",", $toppings);
    }
}