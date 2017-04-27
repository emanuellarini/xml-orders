<?php

namespace AppBundle\Repository\Contract;

use AppBundle\Entity\Person;

interface PersonRepository
{
    public function findAll();
    public function findById($id);
    public function findBy($criteria);
    public function create(Person $person);
}
