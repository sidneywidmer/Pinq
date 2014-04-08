<?php

namespace Pinq\Iterators;

class IntersectionIterator extends OperationIterator
{
    public function valid()
    {
        while(parent::valid()) {
            if($this->OtherValues->Remove(parent::current())) {
                return true;
            }
            
            parent::next();
        }
        return false;
    }
}
