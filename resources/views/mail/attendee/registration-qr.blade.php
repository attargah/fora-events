<!DOCTYPE html>
<html>
<head>
    <title>Your Registration Ticket</title>
</head>
<body>
    <h1>Hello, {{ $attendee->name }}!</h1>
    <p>Thank you for registering for <strong>{{ $attendee->registration->event->title ?? 'the event' }}</strong>.</p>
    
    <p>Here is your registration QR code. Please modify this code at the entrance.</p>
    
    <div style="text-align: center; margin: 20px 0;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $attendee->registration_code }}" alt="Registration QR Code" />
    </div>

    <h3>Ticket Details:</h3>
    <ul>
        <li><strong>Attendee Name:</strong> {{ $attendee->name }}</li>
        <li><strong>Ticket Type:</strong> {{ $attendee->registration->ticket->name ?? 'N/A' }}</li>
    </ul>

    <p>We look forward to seeing you there!</p>
</body>
</html>
