<?php

namespace App\Filament\Resources\MailFormRecords;

use App\Filament\Resources\MailFormRecords\Pages\ManageMailFormRecords;
use App\Models\MailFormRecord;
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

class MailFormRecordResource extends Resource
{

    use SortsNavigationFromConfig;
    protected static ?string $model = MailFormRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string | UnitEnum | null $navigationGroup = 'Forms';
    protected static ?string $navigationLabel = 'Email Form';
    protected static ?string $recordTitleAttribute = 'email';


    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->searchable(),
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
            'index' => ManageMailFormRecords::route('/'),
        ];
    }
}
