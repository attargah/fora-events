<?php

namespace App\Filament\Resources\Checkouts\Pages;

use App\Filament\Resources\Checkouts\CheckoutResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCheckouts extends ManageRecords
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
