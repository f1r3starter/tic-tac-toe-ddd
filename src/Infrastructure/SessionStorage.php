<?php

namespace App\Infrastructure;

use App\Application\GameStorage;
use App\Domain\Entity\Board;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionStorage implements GameStorage
{
    private const STORAGE_KEY = 'board';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return Board
     */
    public function restoreGameState(): Board
    {
        return unserialize($this->session->get(self::STORAGE_KEY), ['allowed_classes' => Board::class]);
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
        $this->session->set(self::STORAGE_KEY, serialize($board));
    }

    public function restartGame(): void
    {
        $this->session->remove(self::STORAGE_KEY);
    }
}
