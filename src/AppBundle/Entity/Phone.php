<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="phones")
 */
class Phone
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
    private $number;

    /**
     * Many Phones have One Person.
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="phones")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;
}
