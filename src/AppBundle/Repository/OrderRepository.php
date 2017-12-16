<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Order;
use AppBundle\Creator\OrderCreator;

/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function createNewOrder($values)
    {
        try {
            $creator = new OrderCreator();

            $order = $creator->setValues($values)->create();

            $this->getEntityManager()->persist($order);

            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
