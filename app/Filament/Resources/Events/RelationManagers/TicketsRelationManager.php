<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';
    protected static ?string $label = 'Ticket';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Ticket Name')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255)
                    ->helperText('Enter a clear and descriptive name for this ticket type (e.g. General Admission, VIP).'),

                Textarea::make('description')
                    ->label('Ticket Description')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('price')
                            ->label('Ticket Price')
                            ->numeric()
                            ->prefix('$')
                            ->nullable()
                            ->helperText('Set the price for one ticket. Leave empty if the ticket is free.'),

                        TextInput::make('quantity')
                            ->label('Total Ticket Quantity')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Total number of tickets.'),
                        TextInput::make('available_quantity')
                            ->label('Available Quantity')
                            ->numeric()
                            ->default(-1)
                            ->helperText('Total number of tickets available. Use -1 for unlimited availability.'),

                        TextInput::make('max_tickets_per_person')
                            ->label('Maximum Tickets Per Person')
                            ->numeric()
                            ->default(-1)
                            ->helperText('Limit how many tickets one person can purchase. Use -1 for no limit.'),
                    ]),
            ]);

    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Ticket Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable()
                    ->placeholder('Free')
                    ->description('Price per ticket'),

                TextColumn::make('quantity')
                    ->label('Total Tickets')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state == -1 ? 'Unlimited' : $state),
                TextColumn::make('available_quantity')
                    ->label('Available Tickets')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state == -1 ? 'Unlimited' : $state),
                TextColumn::make('max_tickets_per_person')
                    ->label('Per-Person Limit')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn($state) => $state == -1 ? 'No limit' : $state)
                    ->description('Maximum tickets per buyer'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
