<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Phone;

class LoadPhoneData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $phone = new Phone();
        $phone->setNumber('(11) 2222-4444');
        $phone->setPerson($this->getReference('person-1'));

        $phone2 = new Phone();
        $phone2->setNumber('(11) 2422-4444');
        $phone2->setPerson($this->getReference('person-1'));

        $phone3 = new Phone();
        $phone3->setNumber('(12) 2222-4444');
        $phone3->setPerson($this->getReference('person-2'));

        $phone4 = new Phone();
        $phone4->setNumber('(44) 0022-4444');
        $phone4->setPerson($this->getReference('person-3'));

        $phone5 = new Phone();
        $phone5->setNumber('(01) 0022-1000');
        $phone5->setPerson($this->getReference('person-3'));

        $manager->persist($phone);
        $manager->persist($phone2);
        $manager->persist($phone3);
        $manager->persist($phone4);
        $manager->persist($phone5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
