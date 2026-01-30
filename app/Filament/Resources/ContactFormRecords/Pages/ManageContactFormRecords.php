<?php

namespace App\Filament\Resources\ContactFormRecords\Pages;

use App\Filament\Resources\ContactFormRecords\ContactFormRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageContactFormRecords extends ManageRecords
{
    protected static string $resource = ContactFormRecordResource::class;

}
