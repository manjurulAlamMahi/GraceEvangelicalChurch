<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Chapter Launched</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f4f4; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); font-family: Arial, sans-serif; color: #333;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h2 style="color: #2c3e50; margin: 0;">📚 New Chapter Launched!</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                                Hey there!<br><br>
                                We're excited to announce that we've just launched a brand new chapter <strong>{{ $chapter->no }}</strong>, titled: <strong>{{ $chapter->title }}</strong>, in the book <strong>{{ $book->title }}</strong>.
                            </p>
                            <p style="font-size: 16px; line-height: 1.6;">
                                <a href="{{ $setting->url }}" style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: #fff; text-decoration: none; border-radius: 5px;">📖 View Book</a>
                            </p>
                            <p style="font-size: 16px; line-height: 1.6; margin-top: 20px;">Happy reading!<br>The {{ $setting->system_title }} Team</p>
                            <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
                            <p style="font-size: 12px; color: #777;">
                                This is an automated message. Please do not reply.<br>
                                &copy; {{ date('Y') }} {{ $setting->system_title }}. All rights reserved.<br>
                                If you no longer wish to receive these emails, you can contact us through our <a href="{{ $setting->url }}">website</a>.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
