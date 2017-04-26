<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Order;

class LoadOrderData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $order1 = $this->createOrder($this->getReference('person-1'), $this->getReference('address-1'), [$this->getReference('item-1'), $this->getReference('item-2')]);
        $order2 = $this->createOrder($this->getReference('person-2'), $this->getReference('address-2'), [$this->getReference('item-3')]);
        $order3 = $this->createOrder($this->getReference('person-3'), $this->getReference('address-3'), [$this->getReference('item-4'), $this->getReference('item-5')]);

        $manager->persist($order1);
        $manager->persist($order2);
        $manager->persist($order3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }

    protected function createOrder($person, $address, $items) {
        $order = new Order();
        $order->setPerson($person);
        $order->setAddress($address);
        for ($i=0; $i < count($items); $i++) {
            $order->addItem($items[$i]);
        }

        return $order;
    }

}
