<?php

namespace AppBundle\Tests\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/orders');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/orders/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
