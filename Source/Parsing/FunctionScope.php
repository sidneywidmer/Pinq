<?php

namespace Pinq\Parsing;

/**
 * Implementation of the function scope inteface.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FunctionScope implements IFunctionScope
{
    /**
     * @var object|null
     */
    protected $thisObject;

    /**
     * @var string|null
     */
    protected $thisType;

    /**
     * @var string|null
     */
    protected $scopeType;

    /**
     * @var array<string, mixed>
     */
    protected $variableValueMap;

    public function __construct(
            $thisObject,
            $scopeType,
            array $variableValueMap
    ) {
        $this->thisObject       = $thisObject;
        $this->thisType         = $thisObject !== null ? get_class($thisObject) : null;
        $this->scopeType        = $scopeType;
        $this->variableValueMap = $variableValueMap;
    }

    /**
     * Creates a function scope instance from the supplied reflection and callable.
     *
     * @param \ReflectionFunctionAbstract $reflection
     * @param callable                    $callable
     *
     * @return self
     */
    public static function fromReflection(\ReflectionFunctionAbstract $reflection, callable $callable)
    {
        if (is_array($callable) && is_object($callable[0])) {
            $thisObject = $callable[0];
            $scopeType  = null;
        } elseif ($reflection->isClosure()) {
            $thisObject = $reflection->getClosureThis();
            $scopeClass = $reflection->getClosureScopeClass();
            $scopeType  = $scopeClass === null ? null : $scopeClass->getName();
        } else {
            $thisObject = null;
            $scopeType  = null;
        }
        $variableValueMap = $reflection->getStaticVariables();

        return new self($thisObject, $scopeType, $variableValueMap);
    }

    public function hasThis()
    {
        return $this->thisObject !== null;
    }

    public function getThis()
    {
        return $this->thisObject;
    }

    public function getThisType()
    {
        return $this->thisType;
    }

    public function getScopeType()
    {
        return $this->scopeType;
    }

    public function getVariableValueMap()
    {
        return $this->variableValueMap;
    }
}