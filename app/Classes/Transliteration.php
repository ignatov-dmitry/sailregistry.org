<?php

namespace App\Classes;


final class Transliteration
{
    private const dictionary = [
        "А" => "A",
        "Б" => "B",
        "В" => "V",
        "Г" => "G",
        "Д" => "D",
        "Е" => "E",
        "Ё" => "E",
        "Ж" => "J",
        "З" => "Z",
        "И" => "I",
        "Й" => "Y",
        "К" => "K",
        "Л" => "L",
        "М" => "M",
        "Н" => "N",
        "О" => "O",
        "П" => "P",
        "Р" => "R",
        "С" => "S",
        "Т" => "T",
        "У" => "U",
        "Ф" => "F",
        "Х" => "H",
        "Ц" => "TS",
        "Ч" => "CH",
        "Ш" => "SH",
        "Щ" => "SCH",
        "Ъ" => "",
        "Ы" => "YI",
        "Ь" => "",
        "Э" => "E",
        "Ю" => "YU",
        "Я" => "YA",
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "e",
        "ж" => "j",
        "з" => "z",
        "и" => "i",
        "й" => "y",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "h",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "sch",
        "ъ" => "y",
        "ы" => "yi",
        "ь" => "",
        "э" => "e",
        "ю" => "yu",
        "я" => "ya",
        "«" => "",
        "»" => "",
        "№" => "",
        "Ӏ" => "",
        "’" => "",
        "ˮ" => "",
        "_" => "-",
        "'" => "",
        "`" => "",
        "^" => "",
        "\." => "",
        "," => "",
        ":" => "",
        "<" => "",
        ">" => "",
        "!" => ""
    ];

    /**
     * @param string $title
     * @param bool $ucFirst
     * @return string
     */
    public static function make(string $title, $ucFirst = false): string
    {
        foreach (self::dictionary as $ru => $en)  {
            $title = mb_eregi_replace($ru, $en, $title);
        }

        $title = mb_strtolower($title);

        if ($ucFirst)
            $title = ucfirst($title);

        return str_replace(' ', '-', $title);
    }
}
