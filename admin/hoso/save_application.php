<?php
//                       _oo0oo_
//                      o8888888o
//                      88" . "88
//                      (| -_- |)
//                      0\  =  /0
//                    ___/`---'\___
//                  .' \\|     |// '.
//                 / \\|||  :  |||// \
//                / _||||| -:- |||||- \
//               |   | \\\  -  /// |   |
//               | \_|  ''\---/''  |_/ |
//               \  .-\__  '-'  ___/-. /
//             ___'. .'  /--.--\  `. .'___
//          ."" '<  `.___\_<|>_/___.' >' "".
//         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//         \  \ `_.   \_ __\ /__ _/   .-` /  /
//     =====`-.____`.___ \_____/___.-`___.-'=====
//                       `=---='
//
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//            amen đà phật copecute 
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
$action = $_POST['action'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
$fullname = $_POST['fullname'];
$birthday = $_POST['birthday'];
$major = $_POST['major'];
$status = $_POST['status'];
$permanent_residence = $_POST['permanent_residence'];
$phone_number = $_POST['phone_number'];
$high_school = $_POST['high_school'];
$you_are = $_POST['you_are'];

if ($action == 'add') {
    $query = $conn->prepare("INSERT INTO admission_application (fullname, birthday, major, status, permanent_residence, phone_number, high_school, you_are) VALUES (:fullname, :birthday, :major, :status, :permanent_residence, :phone_number, :high_school, :you_are)");
} else {
    $query = $conn->prepare("UPDATE admission_application SET fullname = :fullname, birthday = :birthday, major = :major, status = :status, permanent_residence = :permanent_residence, phone_number = :phone_number, high_school = :high_school, you_are = :you_are WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
}

$query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
$query->bindParam(':birthday', $birthday, PDO::PARAM_STR);
$query->bindParam(':major', $major, PDO::PARAM_STR);
$query->bindParam(':status', $status, PDO::PARAM_STR);
$query->bindParam(':permanent_residence', $permanent_residence, PDO::PARAM_STR);
$query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
$query->bindParam(':high_school', $high_school, PDO::PARAM_STR);
$query->bindParam(':you_are', $you_are, PDO::PARAM_STR);

$query->execute();
?>
