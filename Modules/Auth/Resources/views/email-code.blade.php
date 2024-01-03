<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Email</title>
</head>
<body style="font-family: 'Arial', sans-serif;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4;">
    <tr>
        <td align="center" style="padding: 40px 0;">
            <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <tr>
                    <td align="center" style="padding: 40px 20px;">
                        <h1 style="color: #333333;">Password Reset</h1>
                        <p style="color: #666666; line-height: 1.6;">You are receiving this email because we received a password reset request for your account.</p>
                        <p style="color: #666666; line-height: 1.6;">If you did not request a password reset, no further action is required.</p>
                        <a href="" style="display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none; border-radius: 4px; margin-top: 20px;">{{$code}}</a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 20px 20px; background-color: #f8f8f8;">
                        <p style="color: #666666; line-height: 1.6; margin: 0;">&copy; 2023 Your Company. All rights reserved.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
