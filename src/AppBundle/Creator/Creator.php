<?php

namespace AppBundle\Creator;

use AppBundle\Creator\Interfaces\CreatorInterface;

/**
 * I have this class, because every creator is going to have a values variable
 *
 * Class Creator
 * @package AppBundle\Creator
 */
abstract class Creator implements CreatorInterface
{
    /**
     * @var array
     */
    private $values;

    /**
     * Entity to create
     *
     * @var object
     */
    protected $entity;

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param mixed $values
     *
     * @return Creator
     */
    public function setValues($values)
    {
        $this->values = $values;

        return $this;
    }
}