<?php

namespace App\Presentation;

use App\Application\GameModifier;
use App\Domain\Entity\Board;
use App\Presentation\DTO\GameState;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GameStateController
{
    /**
     * @var GameModifier
     */
    private $gameModifier;

    /**
     * @param GameModifier $gameModifier
     */
    public function __construct(GameModifier $gameModifier)
    {
        $this->gameModifier = $gameModifier;
    }

    /**
     * @return JsonResponse
     */
    public function getState(): JsonResponse
    {
        var_dump($this->gameModifier->getState());
        return $this->prepareResponse(
            $this->gameModifier->getState()
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function makeMove(Request $request): Response
    {
        return $this->prepareResponse(
            $this->gameModifier->makeMove($request->get('row'), $request->get('column'))
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function chooseSign(Request $request): JsonResponse
    {
        return $this->prepareResponse(
            $this->gameModifier->chooseSign($request->get('sign'))
        );
    }

    /**
     * @param Board $board
     *
     * @return JsonResponse
     */
    private function prepareResponse(Board $board): JsonResponse
    {
        return new JsonResponse(
            new GameState($board)
        );
    }
}
