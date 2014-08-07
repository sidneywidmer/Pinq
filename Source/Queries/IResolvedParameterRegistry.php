<?php

namespace Pinq\Queries;

use Pinq\Expressions as O;

/**
 * Interface for a resolved parameter registry.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
interface IResolvedParameterRegistry extends \Countable, \ArrayAccess
{
    /**
     * Gets an array of resolved values indexed by their respective
     * parameter identifier.
     *
     * @return mixed[]
     */
    public function getResolvedParameters();
}
