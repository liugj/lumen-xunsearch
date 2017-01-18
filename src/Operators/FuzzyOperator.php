<?php

namespace Liugj\Xunsearch\Operators;

use Liugj\Xunsearch\Operator;

class FuzzyOperator extends Operator
{
    private $fuzzy;

    public function __construct(bool $fuzzy = true)
    {
        $this->fuzzy = $fuzzy;
    }

    public function __toString()
    {
        return (string)$this->fuzzy;
    }
}
