<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="phone_number_idx", columns={"phone_number"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50)
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50)
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=15)
     */
    private $phone_number;

    /**
     * @var string
     *
     * @ORM\Column(name="toppings", type="text")
     */
    private $toppings;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Order
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Order
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Order
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function getToppings()
    {
        return $this->toppings;
    }

    /**
     * The same thing with type, although with toppings, we convert into an array, ucfirst every element and then rejoin it.
     *
     * @return string
     */
    public function getToppingsHuman()
    {
        $ord = explode(",", str_replace("_", " ", $this->toppings));

        $ord = array_map('ucfirst', $ord);

        return implode(",", $ord);
    }

    /**
     * @param string $toppings
     *
     * @return Order
     */
    public function setToppings($toppings)
    {
        $this->toppings = $toppings;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Since types are sometimes stored as snake case, i.e. 'hand_tossed', convert that into a human readable string
     *
     * @return string
     */
    public function getTypeHuman()
    {
        return ucwords(str_replace("_", " ", $this->type));
    }

    /**
     * @param string $type
     *
     * @return Order
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Combine first_name and last_name to get full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    /**
     * Generate the array that will be given to json_encode when returning a JsonResponse
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'phone_number' => $this->getPhoneNumber(),
            'toppings' => $this->getToppings(),
            'type' => $this->getType()
        ];
    }
}

