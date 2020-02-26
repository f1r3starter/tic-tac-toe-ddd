<?php

namespace App\Infrastructure;

use App\Application\GameStorage;
use App\Domain\Entity\Board;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SessionStorage implements GameStorage
{
    private const STORAGE_KEY = 'board';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SessionInterface $session
     * @param SerializerInterface $serializer
     */
    public function __construct(SessionInterface $session, SerializerInterface $serializer)
    {
        $this->session = $session;
        $this->serializer = $serializer;
    }

    /**
     * @return Board
     */
    public function restoreGameState(): Board
    {
        return $this->serializer->deserialize(
            $this->session->get(self::STORAGE_KEY),
            Board::class,
            'json'
        );
    }

    /**
     * @return bool
     */
    public function gameStarted(): bool
    {
        return $this->session->has(self::STORAGE_KEY);
    }

    /**
     * @param Board $board
     */
    public function saveGameState(Board $board): void
    {
        $this->session->set(
            self::STORAGE_KEY,
            $this->serializer->serialize($board, 'json')
        );
    }

    public function restartGame(): void
    {
        $this->session->remove(self::STORAGE_KEY);
    }
}
