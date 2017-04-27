<?php

namespace AppBundle\Tests\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImportControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('XMLs Import Component', $crawler->filter('.container h1')->text());
        $this->assertCount(1, $crawler->filter('input[name="people"]'));
        $this->assertCount(1, $crawler->filter('input[name="shiporders"]'));
    }
}
