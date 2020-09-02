<?php
//$a = range(0,1000);  		//定义$a，为$a开辟一块空间
//var_dump(memory_get_usage());  //查看内存使用情况 int(431056)
//
//$b = $a;  //定义$b,将a的值赋值给b，此时a、b指向同一块空间
//var_dump(memory_get_usage());  //此时变化不大 int(431088)
//
////对a进行修改,此时开辟了一块新的空间，a、b指向不同
//$a[0]=11;
//var_dump(memory_get_usage());  // int(468008)

//$c = [1,2];
//xdebug_debug_zval('c');

//class Person {
//    public $name = 'lili';
//}
//
//$a = new Person();
//xdebug_debug_zval('a');
//
//$b = $a;
//xdebug_debug_zval('a');
//
//$b->name = 'alex';
//xdebug_debug_zval('a');
//var_dump($a->name);      // 'alex'

//$data = ['a','b','c'];
//foreach ($data as $k=>$v){
//    $v = &$data[$k];
//}
//var_dump($data);

//$a = 'lili';
//$b = <<<XXX
//hi $a
//     kongge
//     中文
//            20200901
//XXX;
//
//$c = <<<'XXX'
//hi $a
//     kongge
//     中文
//            20200901
//XXX;
//
//var_dump($b);
//var_dump($c);

//$a = 0.01;
//$b = 0.08;
//var_dump($a+$b);
//var_dump($a+$b == 0.09);

//var_dump('0' == false);
//var_dump('00' == false);
//var_dump('' == false);
//
//var_dump(0.0 == false);
//var_dump(0 == false);
//var_dump([] == false);
//
//var_dump(null == false);
//
//var_dump(' ' == false);     //bool(false)
//var_dump('00' == false);    //bool(false)
//var_dump([0] == false);     //bool(false)

//var_dump($GLOBALS['a']);
//$a = 1;
//var_dump($GLOBALS['a']);
//
//function test()
//{
//    static $a = 0;
//    echo $a;
//    $a++;
//}

//test();
//test();
//test();
//echo __LINE__;

//
//function test() {
//    $foo = "local variable";
//
//    echo '$foo in global scope: ' . $GLOBALS["foo"] . "\n";
//    echo '$foo in current scope: ' . $foo . "\n";
//    echo '$foo in current scope: ' . $GLOBALS["foo"] . "\n";
//}
//
////$foo = "Example content";
//test();
//
//echo '$foo in global scope: ' . $GLOBALS["foo"] . "\n";

//define("FOO",     "something");
//var_dump(FOO);
//
//class A
//{
//
//    const PI = 3.14;
//
//
//}
//
//const PI = 3.14;
//var_dump(PI);

$a = 0;
$b = 0;
if($a = 3 > 0 || $b = 3 > 0){
    var_dump($a,$b);   //bool(true)  int(0)
    $a++;
    $b++;
    var_dump($a,$b);   //bool(true)  int(1)
}
echo true;


















