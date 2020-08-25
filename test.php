<?php
//hash比较缺陷
//        var_dump(md5('s878926199a'));    //0e545993274517709034328855841020
//        var_dump('0e342768416822451524974117254469'==md5('s878926199a'));  //bool(true)
//        var_dump('0e54599'== '0e1244');  //bool(true)
//
//        $a = $_GET['pwd'];
//        $password = "0e1998badb934bce65ad9ba8facc9121";
//        if(md5($a) === $password){  //注意:这里是三个等号"==="进行判断
//            echo 666;
//        }

$arr = ['user'=>true,'pass'=>true];
//$arr = ['user'=>'true','pass'=>'true'];
$str = json_encode($arr);
var_dump($str);
$data = json_decode($str,true);
var_dump($data);
var_dump($data['user'] == 'root' && $data['pass'] == 'mypass');  //true

var_dump(true == 'root');   //bool(true)

$arr = ['user'=>true,'pass'=>true];
$s1 = serialize($arr);
var_dump($s1);
var_dump(unserialize($s1));