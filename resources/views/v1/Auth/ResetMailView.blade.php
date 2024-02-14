<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('style/MailBase.css/mailBase.css') }}">
    <title> Laravel mail Send System </title>
</head>

<body>
    <section class="mailBox">
        <header class="mailBox_header">
            <h1>Hello from Chatvia-chat</h1>
        </header>

        <main class="mailBox_main">
            <p class="mailBox_text"> You've changed your password, here's new password: {{ $newPassword }}</p>
        </main>

        <footer class="mailBox_footer">
            <a href="{{$linkToChatvia_chat}}">Link to Chatvia-chat</a>
        </footer>
    </section>
</body>

</html>