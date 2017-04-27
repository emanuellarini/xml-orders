<?php

namespace AppBundle\Service;

use AppBundle\Repository\Contract\OrderRepository;
use AppBundle\Repository\Contract\PersonRepository;
use AppBundle\Entity\Order;
use AppBundle\Entity\Person;
use AppBundle\Entity\Item;
use AppBundle\Entity\Address;
use AppBundle\Entity\Phone;
use SimpleXMLElement;

class XmlHandler
{
    protected $people;
    protected $orders;
    public function __construct(OrderRepository $orders, PersonRepository $people)
    {
        $this->people = $people;
        $this->orders = $orders;
    }

    public function createData($orders, $people)
    {
        if (!$this->persistPeople($people)) {
            return false;
        }

        if (!$this->persistOrders($orders)) {
            return false;
        }

        return true;
    }

    public function getPeople(SimpleXMLElement $people)
    {
        $peopleData = [];
        foreach ($people as $person) {
            $phonesData = [];
            if (!$person->personid && !$person->personname && !$person->phones) {
                continue;
            }

            foreach ($person->phones->phone as $phone) {
                $phonesData[] = (string) $phone;
            }

            $peopleData[] = [
                'id' => $person->personid ? (string) $person->personid : null,
                'name' => $person->personname ? (string) $person->personname : null,
                'phones' => $phonesData,
            ];
        }

        return $peopleData;
    }

    public function getOrders(SimpleXMLElement $orders)
    {
        $orderData = [];
        foreach ($orders as $order) {
            $items = [];
            foreach ($order->items->item as $item) {
                $items[] = (array) $item;
            }
            $orderData[] = [
                'id' => (string) $order->orderid,
                'person_id' => (string) $order->orderperson,
                'address' => (array) $order->shipto,
                'items' => $items
            ];
        }
        return $orderData;
    }

    protected function persistPeople($people)
    {
        foreach ($people as $person) {
            $persistPerson = new Person();
            $persistPerson->setId($person['id']);
            $persistPerson->setName($person['name']);

            foreach ($person['phones'] as $phone) {
                $persistPhone = new Phone();
                $persistPhone->setNumber($phone);
                $persistPhone->setPerson($persistPerson);
                $persistPerson->addPhone($persistPhone);
            }

            if (!$this->people->create($persistPerson)) {
                return false;
            }
        }

        return true;
    }

    protected function persistOrders($orders)
    {
        foreach ($orders as $order) {
            $persistOrder = new Order();
            $persistOrder->setId($order['id']);

            $persistAddress = new Address();
            $persistAddress->setName($order['address']['name']);
            $persistAddress->setAddress($order['address']['address']);
            $persistAddress->setCity($order['address']['city']);
            $persistAddress->setCountry($order['address']['country']);
            $persistOrder->setAddress($persistAddress);

            $peopleFound = $this->people->findById($order['person_id']);
            $persistOrder->setPerson($peopleFound[0]);

            foreach ($order['items'] as $item) {
                $persistItem = new Item();
                $persistItem->setTitle($item['title']);
                $persistItem->setNote($item['note']);
                $persistItem->setQuantity($item['quantity']);
                $persistItem->setPrice($item['price']);
                $persistOrder->addItem($persistItem);
            }

            if (!$this->orders->create($persistOrder)) {
                return false;
            }
        }

        return true;
    }
}
