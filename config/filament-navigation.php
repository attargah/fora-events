<?php


use App\Filament\Resources\Checkouts\CheckoutResource;
use App\Filament\Resources\ContactFormRecords\ContactFormRecordResource;
use App\Filament\Resources\EventCategories\EventCategoryResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\EventTypes\EventTypeResource;
use App\Filament\Resources\MailFormRecords\MailFormRecordResource;
use App\Filament\Resources\Registrations\RegistrationResource;

return [
    /*
    |--------------------------------------------------------------------------
    | Navigation Sort Order
    |--------------------------------------------------------------------------
    |
    | Here you can specify the sort order for Filament resources.
    | The key should be the fully qualified class name of the resource,
    | and the value should be the integer sort order.
    |
    | Example:
    | App\Filament\Resources\Customers\CustomerResource::class,
    |
    */

    'sort' => [
        CheckoutResource::class,
        EventTypeResource::class,
        EventResource::class,
        EventCategoryResource::class,
        RegistrationResource::class,
        MailFormRecordResource::class,
        ContactFormRecordResource::class
    ],
];
