# How to Queue Email Notifications

To send emails in the background (queue) instead of during the request, follow these steps:

## 1. Implement `ShouldQueue` in Mailables

You need to modify the Mailable classes to implement the `ShouldQueue` interface.

### `app/Mail/Admin/RegistrationCreated.php`

```php
namespace App\Mail\Admin;

use Illuminate\Contracts\Queue\ShouldQueue; // Ensure this is imported
use Illuminate\Mail\Mailable;

// Add "implements ShouldQueue"
class RegistrationCreated extends Mailable implements ShouldQueue
{
    // ...
}
```

### `app/Mail/Attendee/RegistrationQr.php`

```php
namespace App\Mail\Attendee;

use Illuminate\Contracts\Queue\ShouldQueue; // Ensure this is imported
use Illuminate\Mail\Mailable;

// Add "implements ShouldQueue"
class RegistrationQr extends Mailable implements ShouldQueue
{
    // ...
}
```


*Note: Since the Listener creates `Registration` records that might be needed immediately for the response or UI, be careful when queuing the entire listener. Queuing just the Mailables (Method 1) is usually safer for keeping data consistent while making the response faster.*
