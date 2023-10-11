<!-- popup.html -->
<!DOCTYPE html>
<html>

<head>
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css" />
</head>

<body>
    <script>
        // ตัวอย่างโค้ดสำหรับแสดง SweetAlert2 เมื่อบันทึกรายการสำเร็จ
        Swal.fire({
            title: 'บันทึกรายการสำเร็จ',
            icon: 'success',
            text: 'ข้อมูลของคุณถูกบันทึกเรียบร้อยแล้ว',
        });
    </script>
</body>

</html>