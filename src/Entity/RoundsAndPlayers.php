<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RoundAndUsers
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RoundsAndPlayersRepository")
 */
class RoundsAndPlayers
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Round
     * @ORM\ManyToOne(targetEntity="App\Entity\Round", inversedBy="players")
     */
    private $round;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="rounds")
     */
    private $player;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $numberOfRolls;

    public function __construct(Round $round, Player $player)
    {
        $this->round = $round;
        $this->player = $player;
        $this->numberOfRolls = 0;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Round
     */
    public function getRound(): Round
    {
        return $this->round;
    }

    /**
     * @param Round $round
     * @return RoundsAndPlayers
     */
    public function setRound(Round $round): RoundsAndPlayers
    {
        $this->round = $round;
        $round->addPlayerRelation($this);
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return RoundsAndPlayers
     */
    public function setPlayer(Player $player): RoundsAndPlayers
    {
        $this->player = $player;
        $player->addRoundRelation($this);
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfRolls(): int
    {
        return $this->numberOfRolls;
    }

    /**
     * @param int $numberOfRolls
     * @return RoundsAndPlayers
     */
    public function setNumberOfRolls(int $numberOfRolls): RoundsAndPlayers
    {
        $this->numberOfRolls = $numberOfRolls;
        return $this;
    }
}
