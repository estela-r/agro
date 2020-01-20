<?php

declare(strict_types=1);

namespace Tillage\Entity;

use Doctrine\ORM\EntityRepository;

class TillageRepository extends EntityRepository
{
    public function list() {
        
        return $this->createQueryBuilder('t')
            ->select("t.id, t.area, t.createdAt, p.name as plotName, p.crop, tr.name")
            ->join("t.plot", "p")
            ->join("t.tractor", "tr")
            ->getQuery()
            ->getArrayResult();

    }
}