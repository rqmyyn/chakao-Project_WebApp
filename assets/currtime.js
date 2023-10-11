// currtime.js
// ดึงตัวแปรวันที่ปัจจุบัน
var today = new Date();
// รับค่าวันที่ปัจจุบันในรูปแบบ "YYYY-MM-DD"
var year = today.getFullYear();
var month = String(today.getMonth() + 1).padStart(2, '0'); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
var day = String(today.getDate()).padStart(2, '0'); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
document.getElementById("purchase_date").value = year + "-" + month + "-" + day;
