<?php

namespace Mahmoud\EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeEventControllerTest extends WebTestCase
{
    public function testHomeevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/homeEvent');
    }

}
