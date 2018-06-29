<?php

namespace Clarifai\Helpers;

class DateTimeHelper
{
    /**
     * Since PHP doesn't support nanoseconds, we cut out anything after the sixth decimal digit to
     * parse microseconds.
     * @param string $dtString the datetime
     * @return bool|\DateTime the parsed DateTime object, or false if unsuccessful
     */
    public static function parseDateTime($dtString) {
        $dotIndex = strpos($dtString, '.');
        return \DateTime::createFromFormat('Y-m-d\\TH:i:s.u',
            substr($dtString, 0, $dotIndex + 6 + 1), new \DateTimeZone('UTC'));
    }
}