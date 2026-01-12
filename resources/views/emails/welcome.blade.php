<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background-color:#f4f4f4;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:20px;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;padding:30px;">
                
                <!-- Header -->
                <tr>
                    <td align="center" style="padding-bottom:20px;border-bottom:2px solid #007bff;">
                        <h1 style="margin:0;color:#007bff;">
                            Chào mừng đến với {{ config('app.name') }}!
                        </h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:20px 0;color:#333333;">
                        <p>Xin chào <strong>{{ $user->name }}</strong>,</p>

                        <p>Cảm ơn bạn đã đăng ký tài khoản tại hệ thống của chúng tôi.</p>

                        <p><strong>Thông tin tài khoản:</strong></p>
                        <ul style="line-height:1.8;padding-left:20px;">
                            <li><strong>Tên:</strong> {{ $user->name }}</li>
                            <li><strong>Email:</strong> {{ $user->email }}</li>
                            <li><strong>Ngày đăng ký:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
                        </ul>

                        <p>Bạn có thể bắt đầu khám phá ngay:</p>

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding-top:15px;">
                                    <a href="{{ config('app.url') }}"
                                       style="background-color:#007bff;color:#ffffff;
                                       text-decoration:none;padding:12px 30px;
                                       border-radius:5px;display:inline-block;">
                                        Khám phá ngay
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="padding-top:20px;border-top:1px solid #dddddd;font-size:12px;color:#666666;">
                        <p>Email này được gửi tự động, vui lòng không trả lời.</p>
                        <p>&copy; {{ date('Y') }} {{ config('app.name') }}.</p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
