<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Class Round
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RoundRepository")
 */
class Round
{
    public const NUMBERS_DEFAULT = [
        '1' => false,
        '2' => false,
        '3' => false,
        '4' => false,
        '5' => false,
        '6' => false,
        '7' => false,
        '8' => false,
        '9' => false,
        '10' => false
    ];

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="RoundsAndPlayers", mappedBy="round")
     */
    private $players;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $numbers;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isFinished;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->numbers = self::NUMBERS_DEFAULT;
        $this->isFinished = false;
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
    public function getPlayerRelation(): Collection
    {
        return $this->players;
    }

    /**
     * @param Collection $players
     * @return Round
     */
    public function setPlayerRelation(Collection $players): Round
    {
        $this->players = $players;
        return $this;
    }

    /**
     * @param RoundsAndPlayers $roundsAndPlayers
     * @return $this
     */
    public function addPlayerRelation(RoundsAndPlayers $roundsAndPlayers): Round
    {
        $this->players->add($roundsAndPlayers);
        return $this;
    }

    /**
     * @return array
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

    /**
     * @param array $numbers
     * @return Round
     */
    public function setNumbers(array $numbers): Round
    {
        $this->numbers = $numbers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @param bool $isFinished
     * @return Round
     */
    public function setIsFinished(bool $isFinished): Round
    {
        $this->isFinished = $isFinished;
        return $this;
    }
}
