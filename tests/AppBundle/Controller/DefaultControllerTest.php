<?php

namespace tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testEnclosuresAreShownOnTheHomepage()
    {
        $this->loadsFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
        ]);
        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $table = $crawler->filter('.table-enclosures');
        $this->assertCount(3, $table->filter('tbody tr'));
    }

    public function testThatThereIsAnAlarmButtonWithSecurity()
    {
        $fixtures = $this->loadsFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
        ])->getReferenceRepository();

        self::$kernal->getContainer()->get();

        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');

        $enclosure = $fixtures->getReference('carnivorous-enclosure');
        $selector = sprint('#enclosure-%s .button-alarm', $enclosure->getId());

        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }

    public function testItGrowsADinosaurFromSpecification()
    {
         $this->loadsFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
        ]);
        $client = $this->makeClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('Grow dinosaur')->form();
        $form['enclosure']->select(3);
        $form['specification']->setValue('Large herbivore');

        $client->submit($form);

        $this->assertContains(
            'Grew a Large herbivore in enclosure #3',
            $client->getReponse()->getContent()
        );
    }
}