<?php

namespace AppBundle\Repository\Contract;

use AppBundle\Entity\Order;

interface OrderRepository
{
    public function findAll();
    public function findById($id);
    public function findBy($criteria);
    public function create(Order $order);
}
