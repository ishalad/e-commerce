<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Dear Admin,</p>
    <p>We are pleased to inform you that a new {{ $order->dealer_type }} has registered on our website. Below are the details of the {{ $order->dealer_type }}:</p>
    <p>{{ $order->dealer_type }} Information:</p>
    <p>Name: {{ $order->name }}</p>
    <p>Phone: {{ $order->phone }}</p>
    <p>Email: {{ $order->email }}</p>
    <p>Please review the {{ $order->dealer_type }}'s details and proceed with the necessary steps for their onboarding.</p>
    <p>Thank you,</p>
    <P>IndiaZona Team</P>
</body>
</html>