<?php

namespace App\Domain\Exception;

class CellIsOccupied extends BadRequestException
{
    protected $message = 'Cell is already  occupied';
}
