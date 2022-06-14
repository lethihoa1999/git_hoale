<?php
abstract class Country 
{
    protected $slogan;

    public function sayHello(){}

    public function setSlogan($_slogan)
    {
        return $this->slogan = $_slogan. "<br>";
    }
}

interface Boss
{
     function checkValidSlogan($str, $str_a, $str_b); 
}

class EnglandCountry extends Country implements Boss
{
    public function sayHello()
    {
        echo "Hello";
    }

    function checkValidSlogan($str, $str_a, $str_b)
    {
        if (strlen(strripos($str, $str_a)) > 0 || strlen(strripos($str, $str_b)) > 0) {
            echo "true";
        } else {  
            echo "false";
        }
    }
}

class VietnamCountry extends Country implements Boss
{
    public function sayHello()
    {
        echo "Xin chào";
    }

    function checkValidSlogan($str, $str_a, $str_b)
    {   
        if (strlen(strripos($str, $str_a)) > 0 && strlen(strripos($str, $str_b)) > 0) {
            echo "true";
        } else {  
            echo "false";
        }
    }
}

$englandCountry = new EnglandCountry();
$vietnamCountry = new VietnamCountry();
$s_1 = $englandCountry->setSlogan('England is a country that is part of the United Kingdom. It shares land borders with Wales to the west and Scotland to the north. The Irish Sea lies west of England and the Celtic Sea to the southwest.');
$s_2 = $vietnamCountry->setSlogan('Vietnam is the easternmost country on the Indochina Peninsula. With an estimated 94.6 million inhabitants as of 2016, it is the 15th most populous country in the world.');
$a = "england";
$b = "english";
$c = "vietnam";
$d = "hust";   
echo $englandCountry->sayHello() . "<br>"; 
echo $vietnamCountry->sayHello() . "<br>";
echo $englandCountry->checkValidSlogan($s_1, $a, $b) . "<br>";
echo $vietnamCountry->checkValidSlogan($s_2, $c, $d);
?>