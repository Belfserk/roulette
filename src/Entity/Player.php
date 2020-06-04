<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="RoundsAndPlayers", mappedBy="player")
     */
    private $rounds;

    public function __construct()
    {
        $this->rounds = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getRoundRelation(): Collection
    {
        return $this->rounds;
    }

    /**
     * @param Collection $rounds
     * @return Player
     */
    public function setRoundRelation(Collection $rounds): Player
    {
        $this->rounds = $rounds;
        return $this;
    }

    /**
     * @param RoundsAndPlayers $roundsAndUsers
     * @return $this
     */
    public function addRoundRelation(RoundsAndPlayers $roundsAndUsers): Player
    {
        $this->rounds->add($roundsAndUsers);
        return $this;
    }
}
