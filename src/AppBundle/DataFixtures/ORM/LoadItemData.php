<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Item;

class LoadItemData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $item1 = $this->createItem(1, 2, 14.55);
        $item2 = $this->createItem(2, 1, 4.55);
        $item3 = $this->createItem(3, 4, 23.11);
        $item4 = $this->createItem(4, 6, 1.22);
        $item5 = $this->createItem(5, 3, 6.66);

        $manager->persist($item1);
        $manager->persist($item2);
        $manager->persist($item3);
        $manager->persist($item4);
        $manager->persist($item5);

        $this->setReference('item-1', $item1);
        $this->setReference('item-2', $item2);
        $this->setReference('item-3', $item3);
        $this->setReference('item-4', $item4);
        $this->setReference('item-5', $item5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

    protected function createItem($key, $qnty, $price) {
        $item = new Item();
        $item->setTitle('Titulo - ' . $key);
        $item->setNote('Lorem ipsum' . $key);
        $item->setQuantity($qnty);
        $item->setPrice($price);
        return $item;
    }

}
