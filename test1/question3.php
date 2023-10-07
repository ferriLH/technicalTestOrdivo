<?php
    function pattern_count($text, $pattern) {
        $text_arr = str_split($text);
        $count = 0;
        for ($i=0; $i < count($text_arr); $i++) { 
            $temp = $text_arr[$i];
            for ($j=($i+1); $j < count($text_arr); $j++) { 
                $temp .= $text_arr[$j];

                if($temp == $pattern)
                {
                    $count++;
                    break;
                }
            }
        }

        return $count;
    }
    echo "Input: “palindrom”, “ind” \n";
    echo "Output: " . pattern_count("palindrom", "ind") . "\n";
    echo "Input: “abakadabra”, “ab” \n";
    echo "Output: " . pattern_count("abakadabra", "ab") . "\n";
    echo "Input: “hello”, “” \n";
    echo "Output: " . pattern_count("hello", "") . "\n";
    echo "Input: “ababab”, “aba” \n";
    echo "Output: " . pattern_count("ababab", "aba") . "\n";
    echo "Input: “aaaaaa”, “aa” \n";
    echo "Output: " . pattern_count("aaaaaa", "aa") . "\n";
    echo "Input: “hell”, “hello” \n";
    echo "Output: " . pattern_count("hell", "hello") . "\n";
?>