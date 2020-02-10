<?php

namespace App\Domain\Exception;

class CellIsOccupied extends BadRequestException
{
    /**
     * @var string
     */
    protected $message = 'Cell is already  occupied';
}
