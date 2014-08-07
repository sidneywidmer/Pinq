<?php

namespace Pinq\Parsing;

use Pinq\Expressions as O;

/**
 * Interface containing the nessecary methods to resolve any magic
 * constants/scopes of the contained expressions.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
interface IMagicResolvable
{
    /**
     * Resolves any magic constants or scopes with the supplied reflection
     * and returns a new function object with the updated expressions.
     *
     * @param IFunctionMagic $functionMagic
     *
     * @return static
     */
    public function resolveMagic(IFunctionMagic $functionMagic);
}
