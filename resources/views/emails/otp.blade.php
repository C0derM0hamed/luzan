<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>رمز التحقق</title>
</head>
<body style="font-family: 'Cairo', Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 30px 0;">
    <div style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0a7075, #075a5e); padding: 32px 24px; text-align: center;">
            <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700;">مجمع لوزان التخصصي الطبي</h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 14px; margin: 8px 0 0;">رمز التحقق الخاص بك</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 32px; text-align: center;">
            <p style="color: #475569; font-size: 15px; line-height: 1.7; margin: 0 0 24px;">
                تم طلب رمز تحقق للوصول إلى تقاريرك الطبية. استخدم الرمز التالي:
            </p>

            <!-- OTP Code -->
            <div style="background: #f8fafc; border: 2px dashed #0a7075; border-radius: 12px; padding: 20px; margin: 0 auto 24px; display: inline-block;">
                <span style="font-size: 36px; font-weight: 800; letter-spacing: 12px; color: #0a7075; font-family: 'Courier New', monospace; direction: ltr; display: inline-block;">{{ $code }}</span>
            </div>

            <p style="color: #94a3b8; font-size: 13px; margin: 0;">
                ⏱ هذا الرمز صالح لمدة <strong style="color: #e63946;">5 دقائق</strong> فقط
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 24px; text-align: center;">
            <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                إذا لم تطلب هذا الرمز، يرجى تجاهل هذه الرسالة.
            </p>
        </div>
    </div>
</body>
</html>
