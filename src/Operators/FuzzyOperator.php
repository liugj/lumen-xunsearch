<?php

namespace Liugj\Xunsearch\Operators;

use Liugj\Xunsearch\Operator;

class FuzzyOperator extends Operator
{
    private $fuzzy   = true;

    public function __construct($fuzzy)
    {
        $this->fuzzy = $fuzzy;
    }

    public function __toString()
    {
        return $this->fuzzy ?1 :0;
    }
}
