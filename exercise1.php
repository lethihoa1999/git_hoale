<?php 
    function checkValidString($str, $str_a, $str_b) 
    {
        if ((strlen(strstr($str, $str_a)) > 0 && strlen(strstr($str, $str_b)) == 0) 
        || (strlen(strstr($str, $str_b)) > 0 && strlen(strstr($str, $str_a)) == 0) ) {
            return true;
        }
        return false;
    }
    function check($str, $str_a, $str_b)
    {
        if (checkValidString($str, $str_a, $str_b) == true) {
            echo "Chuỗi  hợp lệ. chuỗi bao gồm " . substr_count($str, ".") . " câu" . "<br>";
        } else {
            echo "Chuỗi  không hợp lệ";
        }
    }
    $str_a = "book";
    $str_b = "restaurant";
    function getTextFromFile($file)
    {
        try {
            $myfile = fopen($file, "r");

            return fread($myfile, filesize($file));
        } catch(Exception $e) {
            dd($e);
        } 
    }
    $file1 = getTextFromFile("file1.txt");
    check($file1, $str_a, $str_b);
    $file2 = getTextFromFile("file2.txt");
    check($file2, $str_a, $str_b);
?>
 