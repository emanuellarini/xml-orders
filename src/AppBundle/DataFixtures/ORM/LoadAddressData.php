<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Address;

class LoadAddressData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $address1 = $this->createAddress(1);
        $address2 = $this->createAddress(2);
        $address3 = $this->createAddress(3);

        $manager->persist($address1);
        $manager->persist($address2);
        $manager->persist($address3);

        $this->setReference('address-1', $address1);
        $this->setReference('address-2', $address2);
        $this->setReference('address-3', $address3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

    protected function createAddress($key) {
        $address = new Address();
        $address->setName('Nome - ' . $key);
        $address->setAddress('Endereço' . $key);
        $address->setCity('Cidade - ' . $key);
        $address->setCountry('País - ' . $key);
        return $address;
    }

}
