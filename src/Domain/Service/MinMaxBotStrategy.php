<?php

namespace App\Domain\Service;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class MinMaxBotStrategy implements BotStrategy
{
    private const WIN_SCORE = 10;
    private const LOSE_SCORE = -10;
    private const DRAW_SCORE = 0;
    private const MAX_MOVES = 3;
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
     * @param Sign $playerSign
     */
    public function __construct(Sign $playerSign)
    {
        $this->playerSign = $playerSign;
        $this->botSign = new Sign($playerSign->getOppositeSign());
    }

    /**
     * @param Board $board
     */
    public function makeMove(Board $board): void
    {
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
        if ($currentMoveNum++  ===  self::MAX_MOVES || empty($board->getBoardState()->getAvailableMoves()))
        {
            return $this->evaluate($board,  $currentMoveNum);
        }

        if ($board->getLastMove()->equal($this->botSign)) {
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
        $bestMove = new Move([Move::MIN_VALUE, Move::MIN_VALUE]);

        $bestMove  = array_reduce($availableMoves,  function (Move $bestMove, Move $move) use ($board, $currentMoveNum, &$bestScore) {
            $boardCopy = clone $board;
            $boardCopy->makeMove($move, $this->botSign);
            $this->makeMove($boardCopy);

            $score = $this->miniMax($boardCopy, $currentMoveNum);
            if ($score >= $bestScore) {
                $bestScore = $score;
                return $move;
            }

            return $bestMove;
        },  $bestMove);

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
        $bestMove = new Move([Move::MIN_VALUE, Move::MIN_VALUE]);

        $bestMove  = array_reduce($availableMoves,  function (Move $bestMove, Move $move) use ($board, $currentMoveNum, &$bestScore) {
            $boardCopy = clone $board;
            $boardCopy->makeMove($move, $this->playerSign);

            $score = $this->miniMax($boardCopy, $currentMoveNum);
            if ($score <= $bestScore) {
                $bestScore = $score;
                return $move;
            }

            return $bestMove;
        },  $bestMove);

        $board->makeMove($bestMove, $this->playerSign);

        return $bestScore;
    }

    /**
     * @param Board $board
     *
     * @param int $currentMoveNum
     * @return int
     */
    private function evaluate(Board $board, int $currentMoveNum): int
    {
        $winner = $board->getWinner();
        if (null === $winner) {
            return self::DRAW_SCORE;
        }

        return $winner->equal($this->botSign) ? self::WIN_SCORE - $currentMoveNum : $currentMoveNum - self::LOSE_SCORE;
    }
}
