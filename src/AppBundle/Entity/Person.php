<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="people")
 */
class Person
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * One Person has Many Phones.
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person")
     */
    private $phones;

    public function __construct() {
        $this->phones = new ArrayCollection();
    }
}
