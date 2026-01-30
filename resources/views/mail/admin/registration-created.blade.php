<!DOCTYPE html>
<html>
<head>
    <title>New Registration</title>
</head>
<body>
    <h1>New Registration Alert</h1>
    <p>A new registration has been created.</p>
    
    <h3>Order Details:</h3>
    <ul>
        <li><strong>Order ID:</strong> {{ $registration->id }}</li>
        <li><strong>Name:</strong> {{ $registration->name }}</li>
        <li><strong>Email:</strong> {{ $registration->email }}</li>
        <li><strong>Phone:</strong> {{ $registration->phone }}</li>
        <li><strong>Event:</strong> {{ $registration->event->title ?? 'N/A' }}</li>
        <li><strong>Ticket:</strong> {{ $registration->ticket->name ?? 'N/A' }}</li>
        <li><strong>Quantity:</strong> {{ $registration->quantity }}</li>
        <li><strong>Total Price:</strong> {{ $registration->total_price }}</li>
    </ul>

    <p>Please check the admin panel for more details.</p>
</body>
</html>
