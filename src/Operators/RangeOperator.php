<?php

namespace Liugj\Xunsearch\Operators;

class RangeOperator extends Operator
{
    private $from;
    
    private $to;

    public function __construct($from = null, $to = null)
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
    
    public function __toString()
    {
        return $this->from.'='.$this->to;
    }
}
