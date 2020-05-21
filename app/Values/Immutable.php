<?php

namespace App\Values;

use LogicException;

/**
 * Trait Immutable
 *
 * @package App\Values
 */
trait Immutable
{

    /**
     * @param string $propertyName
     */
    public function __get(string $propertyName)
    {
        throw new LogicException("Can't get property {$propertyName} directly on a Immutable Object at {$this->buildCaller(debug_backtrace()[1])}");
    }

    /**
     * @param string $propertyName
     * @param        $value
     */
    public function __set(string $propertyName, $value)
    {
        throw new LogicException("Can't set property {$propertyName} on a Immutable Object at {$this->buildCaller(debug_backtrace()[1])}");
    }

    /**
     * @param string $propertyName
     */
    public function __unset(string $propertyName)
    {
        throw new LogicException("Can't unset property {$propertyName} on a Immutable Object at {$this->buildCaller(debug_backtrace()[1])}");
    }

    /**
     * @param string $propertyName
     */
    public function __isset(string $propertyName)
    {
        throw new LogicException("Can't perform check in property '{$propertyName}' on a Immutable Object at {$this->buildCaller(debug_backtrace()[1])}");
    }

    /**
     *
     */
    public function __clone()
    {
        throw new LogicException("Does not make sense to clone a Immutable Object at {$this->buildCaller(debug_backtrace()[1])}");
    }

    /**
     * @param array $trace
     * @return string
     */
    private function buildCaller(array $trace): string
    {
        if (!empty($trace['class'])) {

            return "{$trace['class']}{$trace['type']}{$trace['function']}():{$trace['line']}";
        }

        return "{$trace['file']} at function {$trace['function']}() on line {$trace['line']}";
    }

}
