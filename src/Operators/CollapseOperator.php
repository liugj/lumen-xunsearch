<?php

namespace Liugj\Xunsearch\Operators;

use Liugj\Xunsearch\Operator;

class CollapseOperator extends Operator
{
    private $num;

    public function __construct(int $num = 1)
    {
        $this->num = $num;
    }

    public function __toString()
    {
        return (string)$this->num;
    }
}
