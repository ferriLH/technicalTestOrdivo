<?php

    function get_scheme($element) {
        $dom = new DOMDocument;
        $dom->loadHTML($element);
        $tags = [];
        foreach ($dom->getElementsByTagName("*") as $tag) {
            foreach ($tag->attributes as $attribName => $attribNodeVal)
            {
                if (substr($attribName, 0, 3) == "sc-")
                {
                    array_push($tags, substr($attribName,3));
                }
            }
        }

        return json_encode($tags);
    }

    echo "Question 1 \n";
    echo "Input: “<i sc-root>Hello</i>”";
    echo "\nOutput\n";
    echo get_scheme("<i sc-root>Hello</i>");
    echo "\n";
    echo "Input: “<div><div sc-rootbear title=”Oh My”>Hello <i sc-org>World</i></div></div>”";
    echo "\nOutput\n";
    echo get_scheme("<div><div sc-rootbear title='Oh My'>Hello <i sc-org>World</i></div></div>");
    echo "\n";

    function get_scheme_challenge($element) {
        $tags = [];
        for ($i=0; $i < $element->length; $i++) {
            if($element->item($i)->hasAttributes())
            {
                $attr = [];
                foreach ($element->item($i)->attributes as $attribName => $attribNodeVal)
                {
                    if (substr($attribName, 0, 3) == "sc-")
                    {
                        $attr[substr($attribName,3)] = $attribNodeVal->value;
                    }
                }

                array_push($tags, $attr);
                if($element->item($i)->childNodes->length > 0)
                {
                    array_push($tags, array_filter(get_scheme_challenge($element->item($i)->childNodes))  );
                }
            }
        }

        return $tags;
    }

    $dom1 = new DOMDocument;
    $dom2 = new DOMDocument;
    $dom1->loadHTML("<i sc-root='Hello'>World</i>");
    $dom2->loadHTML("<div class='asd' sc-prop sc-alias='' sc-type='Organization'><div sc-name='Alice'>Hello <i sc-name='Wonderland'>World</i></div></div>");

    $xpath1 = new DOMXPath($dom1);
    $xpath2 = new DOMXPath($dom2);
    $get1 = $xpath1->query("//html/body/*");
    $get2 = $xpath2->query("//html/body/*");

    echo"=============================================================================== \n";
    echo "CHALLENGE FOR QUESTION 2 \n";
    echo "Input: “<i sc-root=”Hello”>World</i>”";
    echo "\nOutput: ";
    echo json_encode(array_filter(get_scheme_challenge($get1)));
    echo "\n";
    echo "Input: “<div sc-prop sc-alias=”” sc-type=”Organization”><div sc-name=”Alice”>Hello <i sc-
name=”Wonderland”>World</i></div></div>”";
    echo "\nOutput: \n";
    echo json_encode(array_filter(get_scheme_challenge($get2)), JSON_PRETTY_PRINT);