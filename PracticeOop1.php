<?php
class exerciseString {
    public $Check1;
    public $Check2;

    public function readFile($file)
    {
        try {
            $myfile = fopen($file, "r");
            return fread($myfile, filesize($file));
        } catch(Exception $e) {
            echo("No file existed");
        } 
    }

    public function checkValidString($str, $str_a, $str_b)
    {
        if ((strlen(strstr($str, $str_a)) > 0 && strlen(strstr($str, $str_b)) == 0) 
        || (strlen(strstr($str, $str_b)) > 0 && strlen(strstr($str, $str_a)) == 0)) {
            return true;
        }

        return false;
    }

    public function checkResult($str, $str_a, $str_b) 
    {
        if($this->checkValidString($str, $str_a, $str_b)) {
            return "Chuỗi  hợp lệ";
        }

        return "Chuỗi  không hợp lệ. chuỗi bao gồm " . substr_count($str, ".") . " câu";
    }

    public function writeFile($result_file, $str)
    {
        $openFile = fopen($result_file, "a");
        fwrite($openFile , $str);
    }
}

$str_a = "book";
$str_b = "restaurant";
$object1 = new exerciseString();
$file1 = $object1->readFile("file1.txt") ;
$file2 = $object1->readFile("file2.txt") ;
$str_1 = $object1->checkResult($file1, $str_a, $str_b);
$str_2 = $object1->checkResult($file2, $str_a, $str_b);
$result_file = "result_file.txt";
$str = $str_1."\n".$str_2;
$object1->writeFile($result_file , $str);
?>
