<!DOCTYPE html>
<html lang="vi">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Shop - Nhóm 4</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
 
        body {
            background-color: #ffffff;
            background-image:
                linear-gradient(rgba(220, 38, 38, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(220, 38, 38, 0.07) 1px, transparent 1px);
            background-size: 40px 40px;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
 
        .glow-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 30%, rgba(220, 38, 38, 0.05) 100%);
            pointer-events: none;
        }
 
        .container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.2);
            text-align: center;
            width: 100%;
            max-width: 400px;
            border: 1px solid #eeeeee;
            position: relative;
            z-index: 10;
            animation: slideIn 0.7s ease-out;
        }
 
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
 
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
 
        .logo-box {
            color: #dc2626;
            font-size: 70px;
            margin-bottom: 15px;
            display: inline-block;
            animation: phoneFloat 3s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(220, 38, 38, 0.3));
        }
 
        @keyframes phoneFloat {
 
            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }
 
            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }
 
        /* Thứ tự chữ mới */
        .sub-title-top {
            color: #dc2626;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
 
        h1 {
            color: #1a1a1a;
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 10px;
            letter-spacing: -1px;
        }
 
        .slogan-bottom {
            color: #666;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 35px;
        }
 
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
 
        .btn {
            display: block;
            padding: 16px;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
 
        .btn-login {
            background-color: #dc2626;
            color: #ffffff;
            border: none;
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }
 
        .btn-login:hover {
            background-color: #b91c1c;
            transform: scale(1.03);
            box-shadow: 0 12px 25px rgba(220, 38, 38, 0.4);
        }
 
        .btn-register {
            background-color: transparent;
            color: #dc2626;
            border: 2px solid #dc2626;
        }
 
        .btn-register:hover {
            background-color: rgba(220, 38, 38, 0.05);
            transform: scale(1.03);
        }
 
        .tech-particle {
            position: absolute;
            pointer-events: none;
            color: #dc2626;
            font-weight: bold;
            font-family: monospace;
            z-index: 1;
            animation: floatUp linear infinite;
        }
 
        @keyframes floatUp {
            0% {
                transform: translateY(110vh) rotate(0deg);
                opacity: 0;
            }
 
            10% {
                opacity: 0.8;
            }
 
            90% {
                opacity: 0.8;
            }
 
            100% {
                transform: translateY(-10vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
 
<body>
    <div class="glow-overlay"></div>
 
    <div class="container">
        <div class="logo-box">
            <i class="fa-solid fa-mobile-screen-button"></i>
        </div>
 
        <p class="sub-title-top">Nhóm 4</p>
        <h1>Shop Điện Thoại</h1>
        <p class="slogan-bottom">Uy tín — Chất lượng — Giá rẻ</p>
 
        <div class="button-group">
            <a href="{{ route('login') }}" class="btn btn-login">Đăng nhập ngay</a>
            <a href="{{ route('register') }}" class="btn btn-register">Đăng ký thành viên</a>
        </div>
    </div>
 
    <script>
        const icons = ['0', '1', '📱', '⚡', '</>', '{ }', '■'];
 
        function createParticle() {
            const p = document.createElement('div');
            p.className = 'tech-particle';
            p.innerText = icons[Math.floor(Math.random() * icons.length)];
            p.style.left = Math.random() * 100 + 'vw';
            const size = Math.random() * 15 + 12;
            p.style.fontSize = size + 'px';
            p.style.opacity = Math.random() * 0.4 + 0.4;
            const duration = Math.random() * 4 + 6;
            p.style.animationDuration = duration + 's';
            document.body.appendChild(p);
            setTimeout(() => { p.remove(); }, duration * 1000);
        }
        setInterval(createParticle, 400);
    </script>
</body>
 
</html>