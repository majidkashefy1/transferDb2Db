<?php
$db = require 'db.php';//fill
$configs = require 'configs.php';//fill
include 'functions.php';
//$configs = require 'configs.php';
$tablesOld = include 'from.php';//fill
$tablesNew = include 'to.php';//fill

$connections = connectToDbs($db);

//$oldData = fetchData($connections['old'], $tablesOld, $tablesNew); //array
//users_legal_documents
//tickets
//replies
//documents
//deposit_bank_account_history
$sqlMulti = "select
    users.id as userId
        LEFT JOIN pcmfx_cabin_old.users_legal_documents ON pcmfx_cabin_old.users.id=pcmfx_cabin_old.users_legal_documents.cabin_id
    LEFT JOIN pcmfx_cabin_old.users_api_details ON pcmfx_cabin_old.users.id=pcmfx_cabin_old.users_api_details.user_id
    LEFT JOIN pcmfx_cabin_old.documents ON pcmfx_cabin_old.users.id=pcmfx_cabin_old.documents.uid
    LEFT JOIN pcmfx_cabin_old.accounts ON pcmfx_cabin_old.users.id=pcmfx_cabin_old.accounts.uid
    ;";

$sqlSingle = "select
    users.id as userId
    ,users.name as userName
    ,users.lastname as userLastName
    ,users.email as userEmail
    ,users.phone as userPhone
    ,users.mobile as userMobile
    ,users.sex as gender
    ,users.dob as userBirthDay
    ,users.country as userCountry
    ,users.city as userCity
    ,users.address as userAddress
    ,users.csh as userCitizenShip
    ,users.profession as userProfession
    ,users.experience as userExperience
    ,users.assets as userAssets
    ,users.fatca as userFatf
    ,users.style as userStyle
    ,users.ts as userCreatedAt
    ,users.hear as userHear
    ,users.htext as userHearDesc
    ,users.pin as userPincode
    ,users.lastip as userLastIp
    ,users.activity as userLastActivityTime
    ,users.pincount as userPincount
    ,users.activated as userActivated
    ,users.confirmed as userConfirmed
    ,users.referral as referralId
    ,users.lang as userLang
    ,users.mobstat as userMobileState   
    ,users_passwd.passwd as password
	,users_legal_information.company_name as legalInfoCompanyName
	,users_legal_information.company_national_id as legalInfoNationalId
	,users_legal_information.company_type as legalInfoCompanyType
	,users_legal_information.company_type_description as legalInfoCompanyTypeDesc
	,users_legal_information.registration_city as legalInfoRegistrationCity
	,users_legal_information.registration_date as legalInfoRegistrationDate
    from pcmfx_cabin_old.users 
    LEFT JOIN pcmfx_cabin_old.users_passwd ON pcmfx_cabin_old.users.id=pcmfx_cabin_old.users_passwd.cabin_id 
    LEFT JOIN pcmfx_cabin_old.users_legal_information ON pcmfx_cabin_old.users.id=pcmfx_cabin_old.users_legal_information.cabin_id

;";
if (mysqli_query($connections['old'], $sqlSingle)) {
    $result = mysqli_query($connections['old'], $sqlSingle);
//            $data[$table] = $result->fetch_assoc();
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
//    echo '<pre>';var_dump($data);die;
    foreach ($data as $row) {
//        $userPhone = $row['userPhone'];
//        $userPhone=explode('+', $userPhone);
//        checkPhoneCode('00');
//        echo '<pre>';var_dump($userPhone[1],mb_substr($userPhone[1], 2));die;
        $createdAt = date("Y-m-d", $row['userCreatedAt']);
        $userMobile = $row['userMobile'];
        $password = base64_decode($row['password']);
        echo '<pre>';var_dump($password);die;
        $sqls = ["users" => "INSERT INTO new2.users(`id`,`first_name`,`last_name`,`email`,`created_at`,`last_ip`,`is_active`,`language`,`password`) 
                                        VALUES ('{$row['userId']}','{$row['userName']}','{$row['userLastName']}','{$row['userEmail']}','$createdAt}','{$row['userLastIp']}','{$row['userActivated']}','{$row['userLang']}','{$row['password']}')"];
//        $sqls = ["mobiles" => "INSERT INTO new2.users(id,first_name) VALUES ('{$row['userId']}','{$row['userName']}')"];
//        $sqls = ["dResidencies" => "INSERT INTO new2.document_residencies(id,first_name) VALUES ('{$row['userId']}','{$row['userName']}')"];
//        $sqls = ["locations" => "INSERT INTO new2.user_locations(id,first_name) VALUES ('{$row['userId']}','{$row['userName']}')"];
//        $sqls = ["fatf" => "INSERT INTO new2.financial_action_task_force_answer_users(id,first_name) VALUES ('{$row['userId']}','{$row['userName']}')"];
//
        echo '<pre>';
        var_dump($sqls);
        die;
        foreach ($sqls as $sql) {
            if (mysqli_query($connections['old'], $sql)) {
                echo "New record created successfully" . '<br>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connections['old']);
            }
        }
    }
} else {
    echo "Error: " . $sqlSingle . "<br>" . mysqli_error($connections['old']);
}


echo '<pre>';
//var_dump($oldData, $tablesNew);
die;


foreach ($oldData as $table => $rows) {
//        echo '<pre>';var_dump($table , $columns);die;
    foreach ($rows as $row) {
//        echo '<pre>';var_dump($row);die;
        $tables = [];
        foreach ($row as $column => $value) {
            echo '<pre>';
            var_dump($configs[$table]);
            echo '<pre>';
            var_dump($row, $column, $value);
            die;
        }

        foreach ($tables as $table) {
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

