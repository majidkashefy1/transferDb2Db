<?php
function connectToDbs($db)
{
    $connectionOld = mysqli_connect($db['servernameOld'], $db['usernameOld'], $db['passwordOld'], $db['dbnameOld']);
    $connectionNew = mysqli_connect($db['servernameNew'], $db['usernameNew'], $db['passwordNew'], $db['dbnameNew']);
    if (!$connectionOld || !$connectionNew) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return ['old' => $connectionNew, 'new' => $connectionNew];
}

// make relation
function relation($table1, $table2)
{
    return 2;
}

function fetchData($connection, $table_name)
{
    foreach ($table_name as $table => $columns) {
        $columns = implode(',', $columns);
        $sql = "select {$columns} from  pcmfx_cabin_old.{$table}";
        if (mysqli_query($connection, $sql)) {
            $result = mysqli_query($connection, $sql);
//            $data[$table] = $result->fetch_assoc();
            $data[$table] = mysqli_fetch_all($result, MYSQLI_ASSOC);
//             foreach (mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC) as $row){
////                echo '<pre>';var_dump($row,$tables_new);die;
////            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
    return $data;
}

function insertData($connection, $table_name, $db, $old_data)
{
//    echo '<pre>';var_dump($old_data);die;
    foreach ($table_name as $table => $columns) {
//        echo '<pre>';var_dump($table , $columns);die;
        $column = implode(',', array_keys($columns));
//        foreach (array_values($columns) as $c) {
//            $v[] = [explode('.', $c)[0] => explode('.', $c)[1]];
////            echo '<pre>';var_dump($v, $old_data[$v[0]]);die;
//        }
//        echo '<pre>';var_dump($old_data);die;
//        $values=explode('.', array_values($columns));

        foreach ($old_data as $k=>$v){
            echo '<pre>';var_dump($k,$v);die;
            $sql = "INSERT INTO {$db}.{$table}({$column}) VALUES ({$values})";
        }
        $values = "'" . str_replace(',', "','", implode(',', array_values($columns))) . "'";
        if (mysqli_query($connection, $sql)) {
            echo "New record created successfully" . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
}