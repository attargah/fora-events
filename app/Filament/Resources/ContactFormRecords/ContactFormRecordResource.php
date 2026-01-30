<?php

namespace App\Filament\Resources\ContactFormRecords;

use App\Filament\Resources\ContactFormRecords\Pages\ManageContactFormRecords;
use App\Models\ContactFormRecord;
use App\Traits\SortsNavigationFromConfig;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ContactFormRecordResource extends Resource
{

    use SortsNavigationFromConfig;
    protected static ?string $model = ContactFormRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;

    protected static ?string $navigationLabel = 'Contact Form';
    protected static string | UnitEnum | null $navigationGroup = 'Forms';
    protected static ?string $recordTitleAttribute = 'email';



    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('first_name')->searchable()->toggleable(),
                TextColumn::make('last_name')->searchable()->toggleable(),
                TextColumn::make('email')->searchable()->toggleable()
                    ->searchable(),
                TextColumn::make('subject')->searchable()->toggleable(),
                TextColumn::make('message')->searchable()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactFormRecords::route('/'),
        ];
    }
}
