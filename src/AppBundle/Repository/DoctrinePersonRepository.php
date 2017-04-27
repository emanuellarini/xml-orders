<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\Contract\PersonRepository;
use AppBundle\Entity\Person;

class DoctrinePersonRepository implements PersonRepository
{
    private $manager;
    private $repository;

    public function __construct(EntityManager $manager, EntityRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function findBy($criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function create(Person $person)
    {
        $this->manager->persist($person);
        $this->manager->flush();

        return $person;
    }
}
