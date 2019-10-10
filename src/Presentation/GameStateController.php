<?php

namespace App\Presentation;

use App\Application\GameModifier;
use App\Domain\Entity\Board;
use App\Domain\Exception\IncorrectSign;
use App\Presentation\DTO\GameState;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use function json_decode;
use function json_last_error;

class GameStateController
{
    /**
     * @var GameModifier
     */
    private $gameModifier;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param GameModifier $gameModifier
     * @param SerializerInterface $serializer
     */
    public function __construct(GameModifier $gameModifier, SerializerInterface $serializer)
    {
        $this->gameModifier = $gameModifier;
        $this->serializer = $serializer;
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
            $this->serializer->serialize(new GameState($board), 'json')
        );
    }

    /**
     * @param Request $request
     */
    protected function transformRequest(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data || json_last_error() !== JSON_ERROR_NONE) {
            throw new IncorrectSign();
        }

        $request->request->replace($data);
    }
}
