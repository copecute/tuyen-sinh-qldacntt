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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $permanent_residence = $_POST['permanent_residence'];
    $phone_number = $_POST['phone_number'];
    $high_school = $_POST['high_school'];
    $you_are = $_POST['you_are'];
    $major = $_POST['major'];
    
    try {
        $sql = "INSERT INTO admission_application (fullname, birthday, permanent_residence, phone_number, high_school, you_are, major, status)
                VALUES (:fullname, :birthday, :permanent_residence, :phone_number, :high_school, :you_are, :major, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':permanent_residence', $permanent_residence);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':high_school', $high_school);
        $stmt->bindParam(':you_are', $you_are);
        $stmt->bindParam(':major', $major);
        $stmt->execute();
        
        echo "Application submitted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Application</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Submit Application</h2>
        <form action="submit_application.php" method="post">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="birthday">Birthday:</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="permanent_residence">Permanent Residence:</label>
                <input type="text" class="form-control" id="permanent_residence" name="permanent_residence" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="high_school">High School:</label>
                <input type="text" class="form-control" id="high_school" name="high_school" required>
            </div>
            <div class="form-group">
                <label for="you_are">You Are:</label>
                <input type="text" class="form-control" id="you_are" name="you_are" required>
            </div>
            <div class="form-group">
                <label for="major">Major:</label>
                <input type="text" class="form-control" id="major" name="major" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
