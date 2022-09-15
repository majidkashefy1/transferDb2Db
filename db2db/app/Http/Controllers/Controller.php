<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $dbOld, $dbNew;

    public $areaCode = [
        93 => "Afghanistan",
        0 => "Western Sahara",
        355 => "Albania",
        213 => "Algeria",
        684 => "American Samoa",
        376 => "Andorra",
        244 => "Angola",
        264 => "Namibia",
        672 => "Norfolk Island",
        268 => "Swaziland",
        54 => "Argentina",
        374 => "Armenia",
        297 => "Aruba",
        61 => "Christmas Island",
        43 => "Austria",
        994 => "Azerbaijan",
        242 => "Congo",
        973 => "Bahrain",
        880 => "Bangladesh",
        246 => "Barbados",
        375 => "Belarus",
        32 => "Belgium",
        501 => "Belize",
        229 => "Benin",
        441 => "Bermuda",
        975 => "Bhutan",
        591 => "Bolivia",
        387 => "Bosnia and Herzegovina",
        267 => "Botswana",
        55 => "Brazil",
        284 => "British Virgin Islands",
        673 => "Brunei",
        359 => "Bulgaria",
        226 => "Burkina Faso",
        257 => "Burundi",
        855 => "Cambodia",
        237 => "Cameroon",
        1 => "United States",
        238 => "Cape Verde",
        345 => "Cayman Islands",
        236 => "Central African Republic",
        56 => "Chile",
        86 => "China",
        57 => "Colombia",
        269 => "Mayotte",
        682 => "Cook Islands",
        506 => "Costa Rica",
        385 => "Croatia",
        53 => "Cuba",
        599 => "Netherlands Antilles",
        357 => "Cyprus",
        420 => "Czech Republic",
        45 => "Denmark",
        253 => "Djibouti",
        767 => "Dominica",
        809 => "Dominican Republic",
        593 => "Ecuador",
        20 => "Egypt",
        503 => "El Salvador",
        240 => "Equatorial Guinea",
        291 => "Eritrea",
        372 => "Estonia",
        251 => "Ethiopia",
        500 => "Falkland Islands",
        298 => "Faroe Islands",
        679 => "Fiji",
        358 => "Finland",
        33 => "France",
        594 => "French Guiana",
        689 => "French Polynesia",
        220 => "Gambia",
        995 => "Georgia",
        49 => "Germany",
        233 => "Ghana",
        350 => "Gibraltar",
        30 => "Greece",
        299 => "Greenland",
        473 => "Grenada",
        590 => "Guadeloupe",
        671 => "Guam",
        502 => "Guatemala",
        224 => "Guinea",
        592 => "Guyana",
        509 => "Haiti",
        504 => "Honduras",
        852 => "Hong Kong S.A.R., China",
        36 => "Hungary",
        354 => "Iceland",
        91 => "India",
        62 => "Indonesia",
        98 => "Iran",
        964 => "Iraq",
        353 => "Ireland",
        44 => "United Kingdom",
        972 => "Israel",
        39 => "Vatican",
        225 => "Ivory Coast",
        876 => "Jamaica",
        81 => "Japan",
        962 => "Jordan",
        7 => "Russia",
        254 => "Kenya",
        686 => "Kiribati",
        965 => "Kuwait",
        996 => "Kyrgyzstan",
        856 => "Laos",
        371 => "Latvia",
        961 => "Lebanon",
        266 => "Lesotho",
        231 => "Liberia",
        218 => "Libya",
        423 => "Liechtenstein",
        370 => "Lithuania",
        352 => "Luxembourg",
        389 => "Macedonia",
        261 => "Madagascar",
        265 => "Malawi",
        60 => "Malaysia",
        960 => "Maldives",
        223 => "Mali",
        356 => "Malta",
        692 => "Marshall Islands",
        596 => "Martinique",
        222 => "Mauritania",
        230 => "Mauritius",
        52 => "Mexico",
        373 => "Moldova",
        377 => "Monaco",
        976 => "Mongolia",
        382 => "Montenegro",
        664 => "Montserrat",
        212 => "Morocco",
        258 => "Mozambique",
        95 => "Myanmar",
        674 => "Nauru",
        977 => "Nepal",
        31 => "Netherlands",
        687 => "New Caledonia",
        64 => "New Zealand",
        505 => "Nicaragua",
        227 => "Niger",
        234 => "Nigeria",
        683 => "Niue",
        850 => "North Korea",
        47 => "Norway",
        968 => "Oman",
        92 => "Pakistan",
        680 => "Palau",
        970 => "Palestinian Territory",
        507 => "Panama",
        675 => "Papua New Guinea",
        595 => "Paraguay",
        51 => "Peru",
        63 => "Philippines",
        48 => "Poland",
        351 => "Portugal",
        787 => "Puerto Rico",
        974 => "Qatar",
        262 => "Reunion",
        40 => "Romania",
        250 => "Rwanda",
        290 => "Saint Helena",
        869 => "Saint Kitts and Nevis",
        758 => "Saint Lucia",
        721 => "Sint Maarten",
        508 => "Saint Pierre",
        784 => "Saint Vincent and the Grenadines",
        685 => "Samoa",
        378 => "San Marino",
        239 => "Sao Tome",
        966 => "Saudi Arabia",
        221 => "Senegal",
        381 => "Serbia",
        248 => "Seychelles",
        232 => "Sierra Leone",
        65 => "Singapore",
        421 => "Slovakia",
        386 => "Slovenia",
        677 => "Solomon Islands",
        252 => "Somalia",
        27 => "South Africa",
        82 => "South Korea",
        34 => "Spain",
        94 => "Sri Lanka",
        249 => "Sudan",
        597 => "Suriname",
        46 => "Sweden",
        41 => "Switzerland",
        963 => "Syria",
        886 => "Taiwan",
        992 => "Tajikistan",
        255 => "Tanzania",
        66 => "Thailand",
        228 => "Togo",
        690 => "Tokelau",
        676 => "Tonga",
        868 => "Trinidad and Tobago",
        216 => "Tunisia",
        90 => "Turkey",
        993 => "Turkmenistan",
        649 => "Turks and Caicos Islands",
        688 => "Tuvalu",
        340 => "U.S. Virgin Islands",
        256 => "Uganda",
        380 => "Ukraine",
        971 => "United Arab Emirates",
        598 => "Uruguay",
        998 => "Uzbekistan",
        678 => "Vanuatu",
        58 => "Venezuela",
        84 => "Vietnam",
        967 => "Yemen",
        260 => "Zambia",
        263 => "Zimbabwe",
    ];

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
        'dbnameNew' => "pcmpanelv3",
    ];
//    public $sqlMulti="select
//    users_legal_documents.legal_document_id as legalDocumentId
//    ,users_legal_documents.cabin_id as userId
//    ,users_legal_documents.file_path as filePath
//    ,users_legal_documents.date_time as createdAt
//    from pcmfx_cabin_old.users_legal_documents
//    where users_legal_documents.cabin_id=26756
//;";

    public $sqlSingle = "select
    users.id as userId
    ,users.name as userName
    ,users.lastname as userLastName
    ,users.email as userEmail
    ,users.phone as userPhone
    ,users.mobile as userMobile
    ,users.sex as userGender
    ,users.dob as userBirthDay
    ,users.country as userResidency
    ,users.city as userCity
    ,users.address as userAddress
    ,users.csh as userCitizenShip
    ,users.profession as userProfession
    ,users.experience as userExperience
    ,users.assets as userTradeAssets
    ,users.fatca as userFatf
    ,users.style as userTradeStyle
    ,users.ts as userCreatedAt
    ,users.hear as userHear
    ,users.htext as userHearDesc
    ,users.pin as userPincode
    ,users.lastts as userLastLogin
    ,users.lastip as userLastIp
    ,users.activity as userLastActivityTime
    ,users.pincount as userPincount
    ,users.activated as userActivated
    ,users.confirmed as userConfirmed
    ,users.referral as userReferral
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

        $Q = "INSERT INTO {$this->config['dbnameNew']}.`deposit_exchange_bank_accounts` (`id`, `account_number`, `card_number`, `iban`, `card_name`, `bank_name`) VALUES
(1, '44500081', '58598311200000', 'IR4701522081', 'طھط³طھ 1', 'FG'),
(2, '339000003', '603769700000', 'IR1814003', 'طھط³طھ 2', 'FGFG'),
(3, '11000083', '6104000005', 'IR7101221783', 'طھط³طھ 3', 'FGFG'),
(4, '036200003', '6000000046', 'IR027478003', 'طھط³طھ 4', 'FG');";
        $this->insertSingleRow($Q, 'deposit_exchange_bank_accounts');

        if (mysqli_query($this->dbOld, $this->sqlSingle)) {
            $result = mysqli_query($this->dbOld, $this->sqlSingle);
//            $data[$table] = $result->fetch_assoc();
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($data as $row) {
                if (empty($row['userAddress'])) {
                    $row['userAddress'] = null;
                }


                $lastActivity = date("Y-m-d", $row['userLastActivityTime']);
                $areaCode = $this->convertNumber($row['userPhone'])['code'];
                $phone = $this->convertNumber($row['userPhone'])['number'];
                $areaCodeMobile = $this->convertNumber($row['userMobile'])['code'];
                $mobile = $this->convertNumber($row['userMobile'])['number'];
                $createdAt = date("Y-m-d", $row['userCreatedAt']);
                $lastLogin = date("Y-m-d", $row['userLastLogin']);
                $password = Hash::make(base64_decode($row['password']));
                $emilVerified = now();
                if ($row['userConfirmed'] == 1) {
                    $isBanned = 0;
                } else {
                    $isBanned = 1;
                }
                $registerationDate = null;
                if (!is_null($row['legalInfoRegistrationDate']) && explode('-', $row['legalInfoRegistrationDate'])[0] <= '1401') {
                    $registerationDate = Verta::parse(date($row['legalInfoRegistrationDate']))->datetime()->format('Y-m-d');
                } elseif (!is_null($row['legalInfoRegistrationDate']) && explode('-', $row['legalInfoRegistrationDate'])[0] > '1401') {
                    $registerationDate = \verta($row['legalInfoRegistrationDate'])->datetime()->format('Y-m-d');
                };
                $experienceData = $this->getRelationData('profile_experiences', $row['userExperience'], 'value');
                $gender = $row['userGender'] == 'm' ? 'Male' : 'Female';
                $genderData = $this->getRelationData('profile_genders', $gender, 'value');
                $tradeStyleData = $this->getRelationData('profile_trade_styles', $row['userTradeStyle'], 'value');
                $asset = explode('|', $row['userTradeAssets'])[0];
                $tradeAssetData = $this->getRelationData('profile_trade_assets', ucfirst($asset), 'value');
                $fatfs = explode('|', $row['userFatf']);
                foreach ($fatfs as $fatf) {
                    $fatfsData[] = $this->getRelationData('financial_action_task_force_questions', $fatf, 'key');
                }
                $referral = $this->decodeReferral($row['userReferral']);

                $sqls = [];
                $sqls["users"] = "INSERT INTO {$this->config['dbnameNew']}.users(`id`,`first_name`,`last_name`,`email`,`created_at`,`last_ip`,`is_active`,`language`,`password`,`phone_country_code`,`phone`,`email_verified_at`,`last_activity`,`is_banned`,`pin_count`,`last_login`)
                                        VALUES ('{$row['userId']}','{$row['userName']}','{$row['userLastName']}','{$row['userEmail']}','{$createdAt}','{$row['userLastIp']}','{$row['userActivated']}','{$row['userLang']}','{$password}','{$areaCode}','{$phone}','{$emilVerified}','{$lastActivity}','{$isBanned}','{$row['userPincount']}','{$lastLogin}')";
                $sqls["mobiles"] = "INSERT INTO {$this->config['dbnameNew']}.mobiles(`user_id`,`mobile`,`mobile_country_code`,`is_active`)
                                        VALUES ('{$row['userId']}','{$mobile}','{$areaCodeMobile}','{$row['userMobileState']}')";
                $sqls["user_profiles"] = "INSERT INTO {$this->config['dbnameNew']}.user_profiles(`user_id`,`experience_id`,`gender_id`,`hear_id`,`trade_style_id`,`hear_desc`,`birth_date`,`profession`,`pin_code`,`trade_asset_id`)
                                          VALUES('{$row['userId']}','{$experienceData['id']}','{$genderData['id']}','{$row['userHear']}','{$tradeStyleData['id']}','{$row['userHearDesc']}','{$row['userBirthDay']}','{$row['userProfession']}','{$row['userPincode']}','{$tradeAssetData['id']}')";
                if (is_null($row["userAddress"])) {
                    $sqls["document_residencies"] = "INSERT INTO {$this->config['dbnameNew']}.document_residencies(`user_id`, `address`)
                                          VALUES('{$row['userId']}',null)";
                } else {
                    $sqls["document_residencies"] = "INSERT INTO {$this->config['dbnameNew']}.document_residencies(`user_id`, `address`)
                                          VALUES('{$row['userId']}','{$row["userAddress"]}')";
                }

                $sqls["user_locations"] = "INSERT INTO {$this->config['dbnameNew']}.user_locations(`user_id`,`residency_id`,`citizenship_id`,`city`)
                                          VALUES ('{$row['userId']}','{$row['userResidency']}','{$row['userCitizenShip']}','{$row['userCity']}')";

                if (is_null($registerationDate)) {
                    $sqls["document_legals"] = "INSERT INTO {$this->config['dbnameNew']}.document_legals(`user_id`, `company_type_id`, `company_name`, `company_national_id`, `registration_city`, `registration_date`)
                                          VALUES('{$row['userId']}','{$row['legalInfoCompanyType']}','{$row['legalInfoCompanyName']}','{$row['legalInfoNationalId']}','{$row['legalInfoRegistrationCity']}',null)";
                } else {
                    $sqls["document_legals"] = "INSERT INTO {$this->config['dbnameNew']}.document_legals(`user_id`, `company_type_id`, `company_name`, `company_national_id`, `registration_city`, `registration_date`)
                                          VALUES('{$row['userId']}','{$row['legalInfoCompanyType']}','{$row['legalInfoCompanyName']}','{$row['legalInfoNationalId']}','{$row['legalInfoRegistrationCity']}','{$registerationDate}')";
                }

                $qu = "select * from  {$this->config['dbnameNew']}.document_legals;";
                if (mysqli_query($this->dbNew, $qu)) {
                    $result = mysqli_query($this->dbNew, $qu);
                    $rr=mysqli_fetch_all($result, MYSQLI_ASSOC);

                    return $rr;
                } else {
                    echo "Error: " . $qu . "<br>" . mysqli_error($this->dbNew);
                }


                // insert data to document legal images
                $this->insertToLegalImages($row['userId']);

                foreach ($sqls as $key => $sql) {
                    $this->insertSingleRow($sql, $key);
                }

                //                insert to fatf table answers
                $this->insertToFatf($fatfsData, $row['userId']);

                //add to referral table
                $this->insertToReferral($row['userId'], $referral);

            }
        } else {
            echo "Error: " . $this->sqlSingle . "<br>" . mysqli_error($this->dbOld);
        }

        // insert after user update
//        $qq = "INSERT INTO {$this->config['dbnameNew']}.`deposit_exchange_bank_account_histories` (`id`, `bank_account_id`, `user_id`, `currency_id`, `amount`, `created_at`) VALUES
//(368, 1, 26756, 1, 1234, '2022-09-08 10:28:39'),
//(369, 2, 27152, 2, 4567, '2022-09-07 10:28:39'),
//(370, 3, 27664, 3, 7896, '2022-09-06 10:28:39');";
//        $this->insertSingleRow($qq, 'deposit_exchange_bank_account_histories');
    }

    function connectToDbs($db)
    {
        $connectionOld = mysqli_connect($db['servernameOld'], $db['usernameOld'], $db['passwordOld'], $db['dbnameOld']);
        $connectionNew = mysqli_connect($db['servernameNew'], $db['usernameNew'], $db['passwordNew'], $db['dbnameNew']);
        if (!$connectionOld || !$connectionNew) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $this->dbOld = $connectionOld;
        $this->dbNew = $connectionNew;
    }

    function getRelationData($table, $column, $value)
    {
        $query = "select * from  {$this->config['dbnameNew']}.{$table};";
        if (mysqli_query($this->dbNew, $query)) {
            $result = mysqli_query($this->dbNew, $query);
            foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $r) {
                if (strpos($r[$value], $column) !== false) {
                    return $r;
                }
            }
            return false;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($this->dbNew);
        }
    }

    function convertNumber($number)
    {
        $numberExplode = explode('+', $number);
        $num = "";

        if (!isset($numberExplode[1])) {
            $numberExplode = explode('00', $number);
        }

        if (!isset($numberExplode[1])) {
            $numberExplode[1] = $number;
        }

        $j = 6;
        $data = [];
        for ($i = 1; $i <= $j; $i++) {
            if (isset($this->areaCode[substr($numberExplode[1], 0, $i)])) {
                $data = [
                    'code' => substr($numberExplode[1], 0, $i),
                    'number' => substr($numberExplode[1], $i)
                ];
            }
        }

        return $data;

    }


    public function insertSingleRow($sql, $table): void
    {
        if (mysqli_query($this->dbNew, $this->sqlSingle)) {
            if (mysqli_query($this->dbNew, $sql)) {
                echo "New record created successfully on table |{$table}" . '<br>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->dbNew);
            }
        } else {
            echo "Error: " . $this->sqlSingle . "<br>" . mysqli_error($this->dbOld);
        }
    }


    function decodeReferral($code, $base64 = true)
    {
        $salt = 786;
        $keys = array(
            0 => '87',
            1 => '54',
            2 => '11',
            3 => '95',
            4 => '32',
            5 => '75',
            6 => '15',
            7 => '61',
            8 => '94',
            9 => '38',
        );
        $code = $base64 === true ? substr(base64_decode($code), 0, -3) : $code;
        $id = '';
        foreach (str_split($code, 2) as $key) {
            $array = array_keys($keys, $key);
            $id .= $array[0];
        }
        return $id;
    }

    public function insertToFatf(array $fatfsData, $userId): void
    {
        foreach ($fatfsData as $f) {
            $sql1 = "INSERT INTO {$this->config['dbnameNew']}.financial_action_task_force_answer_users(`user_id`,`question_id`,`value`)
                                          VALUES ('{$userId}','{$f['id']}',1)";

            $this->insertSingleRow($sql1, 'financial_action_task_force_answer_users');
        }
    }

    public function insertToReferral($userId, string $referral): void
    {
        $sql2 = "INSERT INTO {$this->config['dbnameNew']}.referrals(`user_id`,`value`)
                                          VALUES ('{$userId}','{$referral}')";

        $this->insertSingleRow($sql2, 'referrals');
    }

    public function insertToLegalImages($userId): void
    {
        $docLegalMultiSql = "select
    users_legal_documents.legal_document_id as id
    ,users_legal_documents.cabin_id as userId
    ,users_legal_documents.file_path as filePath
    ,users_legal_documents.date_time as createdAt
    from pcmfx_cabin_old.users_legal_documents
    where users_legal_documents.cabin_id={$userId}
;";

        if (mysqli_query($this->dbOld, $docLegalMultiSql)) {
            $result = mysqli_query($this->dbOld, $docLegalMultiSql);
            $newData = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($newData as $r) {
                if (is_null($r['createdAt'])) {
                    $sqlr = "INSERT INTO {$this->config['dbnameNew']}.document_legal_images(`document_legal_id`,`name`)
                                          VALUES ('{$r['legalDocumentId']}','{$r['filePath']}')";
                } else {
                    $sqlr = "INSERT INTO {$this->config['dbnameNew']}.document_legal_images(`document_legal_id`,`name`,`created_at`)
                                          VALUES ('{$r['legalDocumentId']}','{$r['filePath']}','{$r['createdAt']}')";
                }
                $this->insertSingleRow($sqlr, 'document_legal_images');

            }
        } else {
            echo "Error: " . $this->sqlMulti . "<br>" . mysqli_error($this->dbOld);
        }
    }
}
