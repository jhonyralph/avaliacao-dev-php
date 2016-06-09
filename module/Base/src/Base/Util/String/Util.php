<?php
/**
 * @author    Jonathan Ralph
 * @copyright Copyright (c) 2016
 */

namespace Base\String;

/**
 * Utilitários para tratamento de string
 */
class Util
{
    /**
     * Retorna uma string com as primeiras letras das palavras em caixa alta
     *
     * @param  string $string
     * @param  null|int $length
     * @return string
     */
    public static function getFirstUpperLetters($string, $length = null)
    {
        $letters = '';
        $words = preg_split("/\s+/", $string);
        
        foreach ($words as $word) {
            if (ctype_upper($word[0]))
            {
                if (is_numeric($length))
                {
                    $length--;
                    if ($length <= 0)
                        break;
                }
                $letters .= $word[0];
            }           
        }
        
        return $letters;
    }
    
    /**
     * Gera uma string aleatória
     * @param int $length
     * @param string $dictionary
     */
    public static function random($length = 10, $dictionary = null){
        $dictionary = empty($dictionary) ? 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : $dictionary;
        $charactersLength = strlen($dictionary);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $dictionary[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}