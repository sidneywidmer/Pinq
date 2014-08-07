<?php

namespace Pinq\Queries\Operations;

/**
 * Operation query for setting a specified index to a value
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class SetIndex extends IndexOperation
{
    /**
     * @var string
     */
    private $valueParameterId;

    public function __construct($indexParameter, $valueParameterId)
    {
        parent::__construct($indexParameter);
        $this->valueParameterId = $valueParameterId;
    }

    public function getType()
    {
        return self::SET_INDEX;
    }

    /**
     * Gets the value parameter id.
     *
     * @return string
     */
    public function getValueId()
    {
        return $this->valueParameterId;
    }

    public function traverse(OperationVisitor $visitor)
    {
        return $visitor->visitSetIndex($this);
    }
}
