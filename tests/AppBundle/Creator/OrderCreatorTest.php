<?php

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Order;
use AppBundle\Creator\OrderCreator;
use PHPUnit\Framework\TestCase;


class OrderCreatorTest extends TestCase
{
    public function testCreate()
    {
        $values = [
            'first_name' => 'Aylon',
            'last_name' => 'Armstrong',
            'phone_number' => '9035734549',
            'toppings' => 'ham,pepperoni,beef',
            'type' => 'pan'
        ];

        $creator = new OrderCreator();

        $order = $creator->setValues($values)->create();

        $this->assertEquals("Aylon", $order->getFirstName());
    }

    public function testCreateWithInvalidKey()
    {
        $values = [
            'first_nam123e' => 'Aylon',
            'last_name' => 'Armstrong',
            'phone_number' => '9035734549',
            'toppings' => 'ham,pepperoni,beef',
            'type' => 'pan'
        ];

        $creator = new OrderCreator();

        $order = $creator->setValues($values)->create();

        $this->assertNotInstanceOf(Order::class, $order);
        $this->assertEquals("Invalid Key: first_nam123e.", $order);
    }

    public function testCreateWithArrayOfToppings()
    {
        $values = [
            'first_name' => 'Aylon',
            'last_name' => 'Armstrong',
            'phone_number' => '9035734549',
            'toppings' => [
                'ham',
                'pepperoni',
                'beef'
            ],
            'type' => 'pan'
        ];

        $creator = new OrderCreator();

        $order = $creator->setValues($values)->create();

        $this->assertEquals("ham,pepperoni,beef", $order->getToppings());
    }
}