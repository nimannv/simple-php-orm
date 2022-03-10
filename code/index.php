<?php

require_once("Database.php");
require_once("sample_object.php");



//---------------create and set----------------
$tst_obj = new Myobject(
    [
        'fname' => 'Nima',
        'lname' => 'NNV',
        'age' => 27,
        'gender' => 'male',
    ]
);
// // $tst_obj->setField('fname', 'avalwsm');
// // $tst_obj->setField('lname', 'akhar esm');
// // $tst_obj->setField('age', 20);
// // $tst_obj->setField('gender', 'female');
$tst_obj->save();


//---------------get----------------
$list = Myobject::getAll();
var_dump($list);
// $obj = Myobject::getOne();
// $obj->delete();


