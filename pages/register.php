<?php
// ตรวจสอบว่ามีการส่งข้อมูล POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อกับฐานข้อมูล
    include('../config/config.php');

    // รับข้อมูลจากแบบฟอร์ม
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $datebirth = $_POST["datebirth"];
    $address = $_POST["address"];
    $sub_district = $_POST["sub-district"];
    $district = $_POST["district"];
    $city = $_POST["city"];
    $zipcode = $_POST["zipcode"];
    $member_tel = $_POST["member_tel"];
    $password = $_POST["password"];

    $check_duplicate_query = "SELECT * FROM member WHERE member_tel = '$member_tel'"; //sql เช็คเบอร์โทรซ้ำ
    $result = $conn->query($check_duplicate_query);
    if ($result->num_rows > 0) {
        include('../assets/pop-up/user-dup.html'); //show popup duplicate
    } else {
        // เพิ่มข้อมูลลงในฐานข้อมูล
        $sql_customer = "INSERT INTO customer (first_name, last_name, datebirth, address, sub_district, district, city, zipcode)
    VALUES ('$first_name', '$last_name', '$datebirth', '$address', '$sub_district', '$district', '$city', '$zipcode')";

        if ($conn->query($sql_customer) === TRUE) {
            $customer_id = $conn->insert_id; // รับค่า customer_id ที่รันอัตโนมัติ

            // บันทึกข้อมูลบัญชีผู้ใช้ลงในตาราง "สมาชิก" โดยอ้างอิง customer_id
            $sql_member = "INSERT INTO member (customer_id, password, member_tel)
    VALUES ('$customer_id', '$password', '$member_tel')";

            if ($conn->query($sql_member) === TRUE) {
                echo include('../component/pop-up/user-regis-succ.html');
            } else {
                echo "เกิดข้อผิดพลาดในการสร้างบัญชีผู้ใช้: " . $conn->error;
            }
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลลูกค้า: " . $conn->error;
        }

        // ปิดการเชื่อมต่อกับฐานข้อมูล
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน</title>
    <!--Link google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- เพิ่ม Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" href="../images/icon.ico" type="images/x-icon" />
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <h2 class="text-center" style="margin-bottom: 10px;"> <img style="width: 10%;" src="../images/logo.webp" alt="logo"> สมัครสมาชิก</h2>
        <div class="card bg-light p-4">
            <form method="POST">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">ชื่อ</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">นามสกุล</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <!-- Date of Birth -->
                    <div class="form-group col-md-6">
                        <label for="datebirth">วันเดือนปีเกิด</label>
                        <input type="date" value="20/10/1990" class="form-control" id="datebirth" name="datebirth" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="age">อายุ</label>
                        <input type="text" class="form-control" id="age" name="age" readonly>
                        <script>
                            // Check if the date of birth is selected
                            document.getElementById('datebirth').addEventListener('change', function() {
                                var inputDate = document.getElementById("datebirth").value;
                                var birthDate = new Date(inputDate);
                                var today = new Date();

                                var age = today.getFullYear() - birthDate.getFullYear();
                                var monthDiff = today.getMonth() - birthDate.getMonth();

                                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                                    age--;
                                }

                                // Update the "อายุ" input field with the calculated age
                                document.getElementById("age").value = age + ' ปี';
                            });
                        </script>
                    </div>

                </div>
                <div class="form-group">
                    <label for="address">ที่อยู่</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="sub-district">ตำบล</label>
                        <input type="text" class="form-control" id="sub-district" name="sub-district" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="district">อำเภอ</label>
                        <input type="text" class="form-control" id="district" name="district" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">จังหวัด</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zipcode">รหัสไปรษณีย์</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="member_tel">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="member_tel" name="member_tel" required maxlength="10">
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">ลงทะเบียน</button>
                <a href="../index.php" class="btn btn-outline-secondary border-0 ml-1">
                    <i class="fa fa-arrow-left" style="margin-right: 5px;"></i> ย้อนกลับ
                </a>

            </form>
        </div>
    </div>

    <!-- Link เข้ารหัส Bootstrap JS และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


</body>

</html>