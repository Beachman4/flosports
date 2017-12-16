<?php

namespace AppBundle\Creator;

use AppBundle\Creator\Interfaces\CreatorInterface;

abstract class Creator implements CreatorInterface
{
    private $values;

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