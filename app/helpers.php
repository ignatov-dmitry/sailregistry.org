<?php

if (!function_exists('similarColor')){
    function similarColor($str1, $str2): string
    {
        $similarPercent = 0;
        $similarColor = '';
        similar_text($str1, $str2, $similarPercent);

        switch (true) {
            case $similarPercent >= 0 && $similarPercent <= 35:
                $similarColor = 'bg-red';
                break;
            case $similarPercent > 35 && $similarPercent < 100:
                    $similarColor = 'bg-yellow';
                break;
            case $similarPercent = 100:
                $similarColor = 'bg-green';
                break;
        }

        return $similarColor;
    }
}
