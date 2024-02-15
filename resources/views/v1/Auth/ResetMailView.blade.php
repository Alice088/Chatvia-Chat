<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Mail System</title>
</head>

<body>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="padding: 20px; text-align: center; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <h1>Hello from Chatvia-chat</h1>

                            <hr>

                            <p>Your password have changed. a new password:</p>
                            <p style="font-weight: bold; font-size: 18px; color: #FFD700;">{{ $newPassword }}</p>

                            <hr>
                            <br>

                            <a href="{{$linkToChatvia_chat}}">
                                link to Chatvia-chat
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>