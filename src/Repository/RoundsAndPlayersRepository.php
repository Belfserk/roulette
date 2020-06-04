<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class RoundsAndPlayersRepository extends EntityRepository
{
    /**
     * @return int|mixed|string
     */
    public function getNumberOfPlayers()
    {
        return $this->createQueryBuilder('rap')
            ->select('IDENTITY(rap.round) as round')
            ->addSelect('COUNT(rap.player) as players')
            ->groupBy('rap.round')
            ->getQuery()->getResult();
    }

    public function getActivePlayers()
    {
        return $this->createQueryBuilder('rap')
            ->select('IDENTITY(rap.player) as player')
            ->addSelect('COUNT(rap.round) as rounds')
            ->addSelect('AVG(rap.numberOfRolls) as avgRolls')
            ->groupBy('rap.player')
            ->getQuery()->getResult();
    }
}
