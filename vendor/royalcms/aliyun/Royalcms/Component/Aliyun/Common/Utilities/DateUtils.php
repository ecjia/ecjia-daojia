<?php

namespace Royalcms\Component\Aliyun\Common\Utilities;

class DateUtils {
    const FORMAT_RFC822 = 'D, d M Y H:i:s \G\M\T';
    const FORMAT_ISO8601 = 'Y-m-d\TH:i:s.000\Z';
    const FORMAT_HEADER = self::FORMAT_RFC822;
    const FORMAT_DEFAULT = self::FORMAT_HEADER;
            
    public static function formatDate(\DateTime $date, $format = null) {
        if ($format === null) {
            $format = self::FORMAT_HEADER;
        }
        return gmdate($format, $date->getTimestamp());
    }
    
    public static function parseDate($date, $format = null) {
        if ($format === null) {
            $format = self::FORMAT_DEFAULT;
        }
        $timeStamp = strtotime($date);
        return new \DateTime("@$timeStamp");
    }
}
