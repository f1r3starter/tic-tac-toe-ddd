<?php

namespace App\Domain\Strategy;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class MinMaxBotStrategy implements BotStrategy
{
    private const WIN_SCORE = 10;
    private const LOSE_SCORE = -10;
    private const DRAW_SCORE = 0;
    private const MAX_MOVES = 100;
    private const INIT_MOVE = 0;

    /**
     * @var Sign
     */
    private $playerSign;

    /**
     * @var Sign
     */
    private $botSign;

    /**
     * @param Board $board
     * @param Sign $botSign
     */
    public function makeMove(Board $board, Sign $botSign): void
    {
        $this->playerSign = new Sign($botSign->getOppositeSign());
        $this->botSign = $botSign;
        $this->miniMax($board);
    }

    /**
     * @param Board $board
     * @param int $currentMoveNum
     *
     * @return int
     */
    private function miniMax(Board $board, int $currentMoveNum = self::INIT_MOVE): int
    {
        if (self::MAX_MOVES === $currentMoveNum++ || $board->isGameOver()) {
            return $this->evaluate($board);
        }

        if ($board->getLastMove()->equal($this->playerSign)) {
            return $this->maximize($board, $currentMoveNum);
        } else {
            return $this->minimize($board, $currentMoveNum);
        }
    }

    /**
     * @param Board $board
     * @param int $currentMoveNum
     *
     * @return int
     */
    private function maximize(Board $board, int $currentMoveNum): int
    {
        $availableMoves = $board->getBoardState()->getAvailableMoves();

        $bestScore = PHP_INT_MIN;
        $bestMove = new Move(Move::MAX_VALUE, Move::MAX_VALUE);

        $bestMove = array_reduce($availableMoves, function (Move $bestMove, Move $move) use ($board, $currentMoveNum, &$bestScore) {
            $boardCopy = clone $board;
            $boardCopy->makeMove($move, $this->botSign);

            $score = $this->miniMax($boardCopy, $currentMoveNum);
            if ($score >= $bestScore) {
                $bestScore = $score;
                return $move;
            }

            return $bestMove;
        }, $bestMove);

        $board->makeMove($bestMove, $this->botSign);

        return $bestScore;
    }

    /**
     * @param Board $board
     * @param int $currentMoveNum
     *
     * @return int
     */
    private function minimize(Board $board, int $currentMoveNum): int
    {
        $availableMoves = $board->getBoardState()->getAvailableMoves();

        $bestScore = PHP_INT_MAX;
        $bestMove = new Move(Move::MAX_VALUE, Move::MAX_VALUE);

        $bestMove = array_reduce($availableMoves, function (Move $bestMove, Move $move) use ($board, $currentMoveNum, &$bestScore) {
            $boardCopy = clone $board;
            $boardCopy->makeMove($move, $this->playerSign);

            $score = $this->miniMax($boardCopy, $currentMoveNum);
            if ($score <= $bestScore) {
                $bestScore = $score;
                return $move;
            }

            return $bestMove;
        }, $bestMove);

        $board->makeMove($bestMove, $this->playerSign);

        return $bestScore;
    }

    /**
     * @param Board $board
     *
     * @return int
     */
    private function evaluate(Board $board): int
    {
        $winner = $board->getWinner();

        if ($board->isGameOver() && null !== $winner) {
            return $winner->equal($this->botSign) ? self::WIN_SCORE : self::LOSE_SCORE;
        }

        return self::DRAW_SCORE;
    }
}
