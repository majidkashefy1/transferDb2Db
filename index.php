<?php
$db = require 'db.php';//fill
$configs = require 'configs.php';//fill
include 'functions.php';
//$configs = require 'configs.php';
$tablesOld = include 'from.php';//fill
$tablesNew = include 'to.php';//fill

$connections = connectToDbs($db);

//$oldData = fetchData($connections['old'], $tablesOld, $tablesNew); //array
$oldData = [
    'users'=>[
        [
            'id'=>1,
            'name'=>'name1',
            'email'=>'name1@sdf.dsdf',
        ],
        [
            'id'=>2,
            'name'=>'nam222',
            'email'=>'na222@qq.ww',
        ],
    ]
]; //array
echo '<pre>';var_dump($oldData,$tablesNew);die;




















foreach ($oldData as $table => $rows) {
//        echo '<pre>';var_dump($table , $columns);die;
    foreach ($rows as $row) {
//        echo '<pre>';var_dump($row);die;
        $tables=[];
        foreach ($row as $column => $value) {
            echo '<pre>';var_dump($configs[$table]);
            echo '<pre>';var_dump($row,$column,$value);die;
        }

        foreach ($tables as $table){
            $sql = "INSERT INTO {$db['dbnameNew']}.{$table}({$column}) VALUES ({$values})";
        }
    }
    $column = implode(',', array_keys($rows));
//        foreach (array_values($columns) as $c) {
//            $v[] = [explode('.', $c)[0] => explode('.', $c)[1]];
////            echo '<pre>';var_dump($v, $old_data[$v[0]]);die;
//        }
//        echo '<pre>';var_dump($old_data);die;
//        $values=explode('.', array_values($columns));

    foreach ($old_data as $k => $v) {
        echo '<pre>';
        var_dump($k, $v);
        die;
        $sql = "INSERT INTO {$db}.{$table}({$column}) VALUES ({$values})";
    }
    $values = "'" . str_replace(',', "','", implode(',', array_values($columns))) . "'";
    if (mysqli_query($connection, $sql)) {
        echo "New record created successfully" . '<br>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}





//$tablesNew = include 'to.php';//fill

//insertData($connections['new'], $tablesNew, $db['dbnameNew'],$oldData);

