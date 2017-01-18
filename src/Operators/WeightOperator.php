<?php

namespace Liugj\Xunsearch\Operators;

use Liugj\Xunsearch\Operator;

class WeightOperator extends Operator
{
    private $weight;

    public function __construct(string $weight = '')
    {
        $this->weight = $weight;
    }

    public function __toString()
    {
        return $this->weight;
    }
}
