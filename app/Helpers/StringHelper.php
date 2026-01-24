<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * 
     * @param string $name
     * @return string
     */
    public static function removeAcademicTitles($name)
    {
        if (empty($name)) {
            return $name;
        }

        $name = trim($name);

        $prefixPattern = '/^(Prof\.|prof\.|Dr\.|dr\.|DR\.|Drs\.|drs\.|Ir\.|ir\.|Ass\.|ass\.|Apt\.|apt\.|Ners\.|ners\.|Bidan|bidan|Perawat|perawat)\s+/i';
        while (preg_match($prefixPattern, $name)) {
            $name = preg_replace($prefixPattern, '', $name, 1);
        }

        $suffixPattern = '/,?\s*(M\.Pd\.Ked\.|M\.Pd|M\.Kom|M\.Si|M\.E\b|M\.H|M\.M|M\.T|M\.Ag|M\.Sy|M\.Kes|A\.Md|Ph\.D|PhD|M\.D\.|M\.D|S\.Pd|S\.Kom|S\.Si|S\.E\b|S\.H|S\.M|S\.T|S\.Ag|S\.Sy|S\.I\.P|B\.Sc|B\.A|S\.Kep|S\.Kes|S\.Psi|Ns\.|Bd\.|SST\.|Perawat)[\s,]*$/i';
        while (preg_match($suffixPattern, $name)) {
            $name = preg_replace($suffixPattern, '', $name, 1);
        }

        $name = trim($name, ', ');
        $name = trim($name);

        $name = mb_strtoupper($name, 'UTF-8');

        return $name;
    }
}
