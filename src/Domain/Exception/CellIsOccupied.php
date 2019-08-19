<?php

namespace App\Domain\Exception;

class CellIsOccupied extends \InvalidArgumentException
{
    protected $message = 'Cell is already  occupied';
}
