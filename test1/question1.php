<?php

    function sum_deep($arr, $char, $node = 1) {
        $sum = 0;
        foreach ($arr as $c) {
            if(is_array($c))
            {
                $sum = $sum + sum_deep($c, $char, $node + 1);
            }else{
                if (strpos($c, $char) !== false)
                {
                    $sum = $sum + $node;
                }
            }
        }

        return $sum;
    }
    echo "Question 1 \n";
    echo "Input: [“AB”, [“XY”], [“YP”]], ‘Y’ Output: " . sum_deep(["AB", ["XY"], ["YP"]], "Y") . "\n";
    echo "Input: [“”, [“”, [“XXXXX”]]], ‘X’ Output: " . sum_deep(["", ["", ["XXXXX"]]], "X") . "\n";
    echo "Input: [“X”], ‘X’ Output: " . sum_deep(["X"], "X") . "\n";
    echo "Input: [“”], ‘X’ Output: " . sum_deep([""], "X") . "\n";
    echo "Input: [“X”, [“”, [“”, [“Y”], [“X”]]], [“X”, [“”, [“Y”], [“Z”]]]], ‘X’ Output: " . sum_deep( ["X", ["", ["", ["Y"], ["X"]]], ["X", ["", ["Y"], ["Z"]]]], "X") . "\n";
    echo "Input: [“X”, [“”], [“X”], [“X”], [“Y”, [“”]], [“X”]], ‘X’ Output: " . sum_deep(["X", ["", ["", ["Y"], ["X"]]], ["X", ["", ["Y"], ["Z"]]]], "X") . "\n";

    function sum_deep_challenge($arr, $char, $node = 1) {
        $sum = 0;
        $char_arr = str_split($char);

        foreach ($char_arr as $k => $ca) {
            $sum_char = 0;
            foreach ($arr as $c) {
                if(is_array($c))
                {
                    $sum_char = $sum_char + sum_deep_challenge($c, $ca, $node + 1);
                }else{
                    if (strpos($c, $ca) !== false)
                    {
                        $sum_char = $sum_char + $node;
                    }
                }
            }

            $sum = $sum + ($sum_char * ($k+1));
        }

        return $sum;
    }
    echo"=============================================================================== \n";
    echo "CHALLENGE FOR QUESTION 1 \n";
    echo "Input: [“ABAH”, [“CIRCA”], [“CRUMP”, [“IRA”]], [“ALI”]], “ACI” Output: " . sum_deep_challenge(["ABAH", ["CIRCA"], ["CRUMP", ["IRA"]], ["ALI"]], "ACI");