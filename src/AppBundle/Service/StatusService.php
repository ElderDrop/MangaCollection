<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 22.09.17
 * Time: 21:29
 */

namespace AppBundle\Service;


use AppBundle\Entity\Status;
use Doctrine\ORM\EntityManager;

class StatusService
{
    private $em;

    /**
     * StatusService constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $status
     * @return object
     */
    public function getStatusByStatusName(string $status): ?Status
    {
        $status = $this->em->getRepository('AppBundle:Status')->findOneByStatus($status);
        if ($status) return $status;
        return null;
    }
}