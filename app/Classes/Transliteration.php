<?php

namespace App\Classes;


class Transliteration
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

    public static function getDictionary(): array
    {
        return self::dictionary;
    }

    /**
     * @param string $title
     * @param bool $ucFirst
     * @return string
     */
    public static function make(string $title, $ucFirst = false): string
    {
        $title = strtr($title, self::dictionary);

        if ($ucFirst) {
            $title = mb_strtolower($title);
            $title = ucfirst($title);
        }

        return str_replace(' ', '-', $title);
    }
}
