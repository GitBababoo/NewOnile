<?php

/ 1. Define Constants for Database and Google OAuth Configuration
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'otop_database');







?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(to right, #f0f2f5, #d6e0e8);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .welcome-text {
            margin-bottom: 30px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .google-button {
            background-color: #4285f4;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 10px 12px 40px;
            font-size: 1.1em;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;

        }

        .google-button:hover {
            background-color: #3174e0;
        }

        .google-button img {
            width: 30px;
            height: auto;
            margin-right: 15px;
            vertical-align: middle;

        }

        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }

        input::placeholder {
            font-style: italic;
        }

        .forgot {
            margin-top: 5px;
            font-size: 0.9em;
            text-align: right;
            color: #007bff;
            display: block;
        }

        a {
            text-decoration: underline;
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>เข้าสู่ระบบ</h1>
    <button class="google-button">
        <img src="icon-google.png" alt="Google">
        เข้าสู่ระบบด้วย Google
    </button>
<br>
    <form>
        <input type="text" placeholder="ชื่อผู้ใช้งาน หรือ อีเมล" id="username">
        <input type="password" placeholder="รหัสผ่าน" id="password">
        <p class="forgot">ลืมรหัสผ่านใช่ไหม?</p>
        <button type="button" onclick="checkLogin()">เข้าสู่ระบบ</button>
    </form>

    <p>ยังไม่เป็นสมาชิกใช่ไหม? <a href="register.php">สมัครสมาชิกเลย!</a></p>

</div>

<script>
    function checkLogin() {
        alert('ตรวจสอบชื่อผู้ใช้และรหัสผ่านของคุณ');
    }
</script>
</body>
</html>