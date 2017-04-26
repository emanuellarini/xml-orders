<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Person;

class LoadPersonData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $person1 = $this->createPerson(1);
        $person2 = $this->createPerson(2);
        $person3 = $this->createPerson(3);

        $manager->persist($person1);
        $manager->persist($person2);
        $manager->persist($person3);

        $this->setReference('person-1', $person1);
        $this->setReference('person-2', $person2);
        $this->setReference('person-3', $person3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    protected function createPerson($key) {
        $person = new Person();
        $person->setName('Nome - ' . $key);
        return $person;
    }

}
