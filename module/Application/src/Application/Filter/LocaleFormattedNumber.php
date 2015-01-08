<?php
/**
 * zf2-skeleton
 *
 * @link        https://github.com/basarevych/zf2-skeleton
 * @copyright   Copyright (c) 2014 basarevych@gmail.com
 * @license     http://choosealicense.com/licenses/mit/ MIT
 */

namespace Application\Filter;

use NumberFormatter;
use Locale;
use Zend\Filter\AbstractFilter;

/**
 * Convert Locale-formatted string to a number
 *
 * @category    Application
 * @package     Validator
 */
class LocaleFormattedNumber extends AbstractFilter
{
    /**
     *
     * Returns the string $value with characters stripped from the beginning and end
     *
     * @param  string $value
     * @return string
     * @see    Zend\Filter\FilterInterface
     */
    public function filter($value)
    {
        $fmt = new NumberFormatter(Locale::getDefault(), NumberFormatter::DECIMAL);
        $parse = $fmt->parse($value);
        if ($parse !== false)
            return $parse;

        return $value;
    }
}