<?php

namespace Pinq\Iterators;

/**
 * Provider class for accessing the built in provider schemes.
 * Currently the implemented schemes are as follows:
 *  - Generators,   >= 5.5.0
 *  - Iterators,    >= 5.4.0
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
final class SchemeProvider
{
    private static $schemesInPriorityOrder;

    /**
     * @return IIteratorScheme[]
     */
    public static function getAvailableSchemes()
    {
        if (self::$schemesInPriorityOrder === null) {

            if (Generators\GeneratorScheme::compatiableWith(PHP_VERSION)) {
                self::$schemesInPriorityOrder[] = new Generators\GeneratorScheme();
            }

            if (Standard\IteratorScheme::compatiableWith(PHP_VERSION)) {
                self::$schemesInPriorityOrder[] = new Standard\IteratorScheme();
            }
        }

        return self::$schemesInPriorityOrder;
    }

    /**
     * @return IIteratorScheme
     */
    public static function getDefault()
    {
        $schemes = self::getAvailableSchemes();
        if (empty($schemes)) {
            throw new \Pinq\PinqException(
                    'Cannot get default iterator scheme: None are supported in the PHP v%s',
                    PHP_VERSION);
        }

        return clone $schemes[0];
    }
}
