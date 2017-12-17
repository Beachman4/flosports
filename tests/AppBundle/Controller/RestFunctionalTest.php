<?php

namespace Tests\AppBundle\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


class RestFunctionalTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000'
        ]);
    }


    public function testCreate()
    {
        $preCount = $this->getOrdersCount('5555555555');
        $expectedCount = $preCount + 1;

        $createArray = [
            'first_name' => 'Mike',
            'last_name' => 'Simpson',
            'phone_number' => '5555555555',
            'toppings' => [
                'beef',
                'mushrooms'
            ],
            'type' => 'pan'
        ];

        $this->extractJson($this->client->request('POST', '/api/orders', [
            'form_params' => $createArray
        ]));

        $actualCount = $this->getOrdersCount('5555555555');

        $this->assertEquals($expectedCount, $actualCount);
    }

    public function testShouldBeBadRequest()
    {
        $createArray = [
            'first_name' => 'Mike',
            'last_name' => 'Simpson',
            'phone_number' => '555-555-5555',
            'toppings' => [
                'beef',
                'mushrooms'
            ],
            'type' => 'pan'
        ];

        try {
            $result = $this->client->request('POST', '/api/orders', [
                'form_params' => $createArray
            ]);
        } catch (BadResponseException $e) {
            $this->assertEquals(400, $e->getCode());
        }
    }

    private function extractJson(ResponseInterface $response)
    {
        $body = (string) $response->getBody();

        return json_decode($body, true);
    }


    private function getOrdersCount($number)
    {
        $test = $this->extractJson($this->client->request('GET', '/api/orders', [
            'query' => [
                'phone_number' => $number
            ]
        ]));
        return count($test);
    }
}