<?php

namespace Liugj\Xunsearch\Operators;

use Liugj\Xunsearch\Operator;

class CollapseOperator extends Operator
{
    private $num   = 1;

    public function __construct($num)
    {
        $this->num = $num;
    }

    public function __toString()
    {
        return $this->num;
    }
}
