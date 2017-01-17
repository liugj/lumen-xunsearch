<?php

namespace Liugj\Xunsearch\Operators;

use Liugj\Xunsearch\BasicOperator;

class RangeOperator extends BasicOperator
{
    private $from = null;
    
    private $to   = null;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }
}
