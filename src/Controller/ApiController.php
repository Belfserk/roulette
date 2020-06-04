<?php

namespace App\Controller;

use App\Entity\Round;
use App\Entity\RoundsAndPlayers;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route(path="/api")
 */
class ApiController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @Route(path="/init",
     *     name="api_init",
     *     methods={"POST"},
     *     condition="request.isXmlHttpRequest()",
     *     options={"expose"=true})
     */
    public function initRoulette(Request $request, EntityManagerInterface $em)
    {
        $playerId = $request->request->get('playerId');
        $player = $em->getRepository(Player::class)->findOneBy(['id' => $playerId]) ?? new Player();

        $round = $em->getRepository(Round::class)->findOneBy(['isFinished' => false]) ?? new Round();

        $roundAndPlayer = $em->getRepository(RoundsAndPlayers::class)->findOneBy([
            'round' => $round,
            'player' => $player
        ]);

        if (is_null($roundAndPlayer)) {
            $roundAndUser = new RoundsAndPlayers($round, $player);

            $em->persist($player);
            $em->persist($round);
            $em->persist($roundAndUser);

            $em->flush();
        }

        return new JsonResponse([
            'playerId' => $player->getId(),
            'round' => $round->getId()
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @Route(path="/roll",
     *     name="api_roll",
     *     methods={"POST"},
     *     condition="request.isXmlHttpRequest()",
     *     options={"expose"=true})
     */
    public function roll(Request $request, EntityManagerInterface $em)
    {
        $playerId = $request->request->get('playerId');
        $player = $em->getRepository(Player::class)->findOneBy(['id' => $playerId]);
        $round = $em->getRepository(Round::class)->findOneBy(['isFinished' => false]);

        $roundAndPlayer = $em->getRepository(RoundsAndPlayers::class)->findOneBy([
            'round' => $round,
            'player' => $player
        ]) ?? new RoundsAndPlayers($round, $player);
        $roundAndPlayer->setNumberOfRolls($roundAndPlayer->getNumberOfRolls() + 1);
        $em->persist($roundAndPlayer);

        $allNumbers = $round->getNumbers();
        $rolledNumber = $this->getRolledNumber($allNumbers);

        if ($rolledNumber === 0) {
            $round->setIsFinished(true);
            $newRound = new Round();
            $em->persist($newRound);
        } else {
            $allNumbers[$rolledNumber] = true;
            $round->setNumbers($allNumbers);
        }

        $em->persist($round);
        $em->flush();

        return new JsonResponse([
            'round' => $round->getId(),
            'rolledNumber' => $rolledNumber
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @Route(path="/playersnumber",
     *     name="api_number_of_players",
     *     methods={"GET"},
     *     condition="request.isXmlHttpRequest()",
     *     options={"expose"=true})
     */
    public function numberOfPlayers(EntityManagerInterface $em)
    {
        return new JsonResponse(
            $em->getRepository(RoundsAndPlayers::class)->getNumberOfPlayers()
        );
    }

    /**
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @Route(path="/playersactive",
     *     name="api_active_players",
     *     methods={"GET"},
     *     condition="request.isXmlHttpRequest()",
     *     options={"expose"=true})
     */
    public function activePlayers(EntityManagerInterface $em)
    {
        return new JsonResponse(
            $em->getRepository(RoundsAndPlayers::class)->getActivePlayers()
        );
    }

    /**
     * @param array $allNumbers
     * @return int
     */
    private function getRolledNumber(array $allNumbers): int
    {
        $availableNumbers = array_keys(
            array_filter($allNumbers, function ($isAvailable) {
                return !$isAvailable;
            })
        );

        $rolledNumber = 0;
        if (!empty($availableNumbers)) {
            $weightSum = array_sum($availableNumbers);
            $rand = rand(0, $weightSum - 1);
            for ($i = 0; $i < count($availableNumbers); $i++) {
                if ($rand < $availableNumbers[$i]) {
                    $rolledNumber = $availableNumbers[$i];
                    break;
                } else {
                    $rand -= $availableNumbers[$i];
                }
            }
        }

        return $rolledNumber;
    }
}
