<?php

namespace App\Filament\Resources\Checkouts;

use App\Filament\Resources\Checkouts\Pages\ManageCheckouts;
use App\Models\Checkout;
use App\Traits\SortsNavigationFromConfig;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CheckoutResource extends Resource
{
    use SortsNavigationFromConfig;
    protected static ?string $model = Checkout::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;


    protected static string | UnitEnum | null $navigationGroup = 'Checkout';
    protected static ?string $recordTitleAttribute = 'name';


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id','desc')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(),
                TextColumn::make('name')
                    ->label('Customer Name')
                    ->searchable()
                    ->placeholder('Form is Not Filled')
                    ->description(fn (Checkout $record) => $record?->email_address),
                TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                TextColumn::make('ticket.name')
                    ->label('Ticket')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Customer Information')
                ->columns()
                ->schema([
                    TextEntry::make('name')->placeholder('Form is Not Filled'),
                    TextEntry::make('email_address')
                      ->placeholder('Form is Not Filled')
                        ->label('Email')
                        ->copyable(),
                    TextEntry::make('phone_number')
                      ->placeholder('Form is Not Filled')
                        ->label('Phone'),
                    TextEntry::make('ip_address')
                        ->label('IP Address')
                        ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),
                ]),
            Section::make('Billing Address')
                ->columns()
                ->schema([
                    TextEntry::make('country')
                      ->placeholder('Form is Not Filled'),
                    TextEntry::make('city')
                      ->placeholder('Form is Not Filled'),
                    TextEntry::make('state')
                      ->placeholder('Form is Not Filled'),
                    TextEntry::make('address')
                      ->placeholder('Form is Not Filled')
                        ->columnSpanFull(),
                ]),

            Section::make('Order Details')
                ->columnSpanFull()
                ->schema([
                    Flex::make([
                        TextEntry::make('event.title')
                            ->label('Event'),
                        TextEntry::make('ticket.name')
                            ->label('Ticket Type'),
                    ]),
                    Flex::make([
                        TextEntry::make('amount')
                            ->money('USD')
                            ->label('Unit Price'),
                        TextEntry::make('quantity'),

                        TextEntry::make('total')
                            ->money('USD')
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),
                    ])

                ]),


        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCheckouts::route('/'),
        ];
    }
}
