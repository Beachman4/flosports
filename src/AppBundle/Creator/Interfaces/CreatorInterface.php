<?php

namespace AppBundle\Creator\Interfaces;


/**
 * Entity Creator Interface
 *
 * Interface CreatorInterface
 * @package AppBundle\Creator\Interfaces
 */
interface CreatorInterface
{
    /**
     * Basically, when given an array of values, create a new Entity, so it can be saved
     *
     * @return object
     */
    public function create();
}