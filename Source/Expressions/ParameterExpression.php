<?php

namespace Pinq\Expressions;

/**
 * Expression representing a function parameter.
 *
 * @author Elliot Levin <elliot@aanet.com.au>
 */
class ParameterExpression extends Expression
{
    private $Name;
    private $TypeHint;
    private $HasDefaultValue;
    private $DefaultValue;
    private $IsPassedByReference;

    public function __construct($Name, $TypeHint = null, $HasDefaultValue = false, $DefaultValue = null, $IsPassedByReference = false)
    {
        $this->Name = $Name;
        $this->TypeHint = $TypeHint;
        $this->HasDefaultValue = $HasDefaultValue;
        $this->DefaultValue = $DefaultValue;
        $this->IsPassedByReference = $IsPassedByReference;
    }

    public function Simplify()
    {
        return $this;
    }    

    public function Traverse(ExpressionWalker $Walker)
    {
        $Walker->WalkParameter($this);
    }
    
    public function GetName()
    {
        return $this->Name;
    }

    public function HasTypeHint()
    {
        return $this->TypeHint !== null;
    }

    public function GetTypeHint()
    {
        return $this->TypeHint;
    }

    public function HasDefaultValue()
    {
        return $this->HasDefaultValue;
    }

    public function GetDefaultValue()
    {
        return $this->DefaultValue;
    }

    public function IsPassedByReference()
    {
        return $this->IsPassedByReference;
    }
    
    public function Update($Name, $TypeHint, $HasDefaultValue, $DefaultValue, $IsPassedByReference)
    {
        if($this->Name === $Name
                && $this->TypeHint === $TypeHint
                && $this->HasDefaultValue === $HasDefaultValue
                && $this->DefaultValue === $DefaultValue
                && $this->IsPassedByReference === $IsPassedByReference) {
            return $this;
        }
        
        return new self($Name, $TypeHint, $HasDefaultValue, $DefaultValue, $IsPassedByReference);
    }

    protected function CompileCode(&$Code)
    {
        if($this->TypeHint !== null) {
            $Code .= $this->TypeHint . ' ';
        }
        
        if($this->IsPassedByReference) {
            $Code .= '&';
        }
        $Code .= '$' . $this->Name;
        
        if($this->HasDefaultValue) {
            $Code .= ' = ' . var_export($this->DefaultValue, true);
        }
    }

}
