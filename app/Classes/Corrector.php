<?php

namespace App\Classes;


class Corrector extends Transliteration
{
    private array $words = array();

    public function setWords(array $words)
    {
        $this->words = array();
        foreach ($words as $word)
            $this->words[$word] = self::make($word);
    }

    public function correctWord($words): array
    {
        //Перебираем массив введенных слов и записываем результаты в новый массив
        $num = 0;
        $correct = array();

        while($num < count($words)) {
            $myWord = $words[$num];
            $num++;

            $enteredWord = self::make($myWord);

            $possibleWord = array();

            foreach($this->words as $n => $k) {
                if(levenshtein(metaphone($enteredWord), metaphone($k)) < (mb_strlen(metaphone($enteredWord)) / 2) + 1) {
                    if(levenshtein($enteredWord, $k) < mb_strlen($enteredWord) / 2 + 1) {
                        $possibleWord[$n] = $k;
                    }
                }
            }

            $similarity = 0;
            $meta_similarity = 0;
            $min_levenshtein = 1000;
            $meta_min_levenshtein = 1000;

            //Считаем минимальное расстояние Левенштейна
            if(count($possibleWord)) {
                foreach($possibleWord as $n) {
                    $min_levenshtein = min($min_levenshtein, levenshtein($n, $enteredWord));
                }

                //Считаем максимальное значение подобности слов
                foreach($possibleWord as $n) {
                    if(levenshtein($n, $enteredWord) == $min_levenshtein) {
                        $similarity = max($similarity, similar_text($n, $enteredWord));
                    }
                }

                $result = NULL;
                $meta_result = NULL;

                //Проверка всего слова
                foreach($possibleWord as $n => $k) {
                    //if(levenshtein($k, $enteredWord) <= $min_levenshtein + 100) {
                        if(similar_text($k, $enteredWord) >= $similarity - 1) {
                            $result[$n] = $k;
                        }
                    //}
                }

                $meta_result = $result;
//dd( $result);
//                foreach($result as $n) {
//                    $meta_min_levenshtein = min($meta_min_levenshtein, levenshtein(metaphone($n), metaphone($enteredWord)));
//                }
//
//                //Считаем максимальное значение подобности слов
//                foreach($result as $n) {
//                    if(levenshtein($k, $enteredWord) == $meta_min_levenshtein) {
//                        $meta_similarity = max($meta_similarity, similar_text(metaphone($n), metaphone($enteredWord)));
//                    }
//                }
//
//
//
//                //Проверка через метафон
//                foreach($result as $n => $k) {
//                    if(levenshtein(metaphone($k), metaphone($enteredWord)) <= $meta_min_levenshtein + 1) {
//                        if(similar_text(metaphone($k), metaphone($enteredWord)) >= $meta_similarity) {
//                            $meta_result[$n] = $k;
//                        }
//                    }
//                }

                $correct = array_merge($correct, array_keys($meta_result));
            }
            else {
                $correct[] .= $myWord;
            }
        }
        return $correct;
    }
}
