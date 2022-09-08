<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $dbOld, $dbNew;
    public $config = [
        //old connection
        'servernameOld' => "localhost",
        'usernameOld' => "root",
        'passwordOld' => "",
        'dbnameOld' => "pcmfx_cabin_old",
//new connection
        'servernameNew' => "localhost",
        'usernameNew' => "root",
        'passwordNew' => "",
        'dbnameNew' => "new2",
    ];
public $sqlSingle = "select
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

    public function index()
    {
        $this->connectToDbs($this->config);
        if (mysqli_query($this->dbOld, $this->sqlSingle)) {
            $result = mysqli_query($this->dbOld, $this->sqlSingle);
//            $data[$table] = $result->fetch_assoc();
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
                                        VALUES ('{$row['userId']}','{$row['userName']}','{$row['userLastName']}','{$row['userEmail']}','{$createdAt}','{$row['userLastIp']}','{$row['userActivated']}','{$row['userLang']}','{$row['password']}')"];
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
        }
        else {
            echo "Error: " . $sqlSingle . "<br>" . mysqli_error($connections['old']);
        }
    }

    function connectToDbs($db)
    {
        $connectionOld = mysqli_connect($db['servernameOld'], $db['usernameOld'], $db['passwordOld'], $db['dbnameOld']);
        $connectionNew = mysqli_connect($db['servernameNew'], $db['usernameNew'], $db['passwordNew'], $db['dbnameNew']);
        if (!$connectionOld || !$connectionNew) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $this->dbOld= $connectionOld;
        $this->dbNew= $connectionNew;
    }


}
