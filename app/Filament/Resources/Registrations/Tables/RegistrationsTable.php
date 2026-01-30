<?php

namespace App\Filament\Resources\Registrations\Tables;

use App\Models\Event;
use App\Models\EventTicket;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id','desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('ticket.name')
                    ->label('Ticket')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Customer Name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Customer Email')
                    ->toggleable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Customer Phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->toggleable(),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('item_price')
                    ->label('Price')
                    ->money('USD')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('USD')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->preload()
                    ->searchable(),



                Filter::make('created_at')
                    ->label('Created Date')
                    ->schema([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn($q) => $q->whereDate('created_at', '>=', $data['from'])
                            )
                            ->when(
                                $data['until'],
                                fn($q) => $q->whereDate('created_at', '<=', $data['until'])
                            );
                    }),


                Filter::make('total_price')
                    ->label('Total Price')
                    ->schema([
                        TextInput::make('min')
                            ->label('Min')
                            ->numeric()
                            ->placeholder('0'),

                        TextInput::make('max')
                            ->label('Max')
                            ->numeric()
                            ->placeholder('1000'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['min'],
                                fn($q) => $q->where('total_price', '>=', $data['min'])
                            )
                            ->when(
                                $data['max'],
                                fn($q) => $q->where('total_price', '<=', $data['max'])
                            );
                    }),
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
