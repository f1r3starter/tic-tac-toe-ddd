<?php

namespace App\Presentation;

use App\Application\GameModifier;
use App\Domain\Entity\Board;
use App\Domain\Exception\IncorrectSign;
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
        $this->transformRequest($request);

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
        $this->transformRequest($request);

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

    /**
     * @param Request $request
     */
    protected function transformRequest(Request $request): void
    {
        $data = \json_decode($request->getContent(), true);

        if (\json_last_error() !== JSON_ERROR_NONE || null === $data) {
            throw new IncorrectSign();
        }

        $request->request->replace($data);
    }
}
