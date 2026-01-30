<?php

namespace App\Filament\Resources\Events\Tables;

use App\Enums\EventStatus;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table->defaultSort('id','desc')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                ImageColumn::make('banner'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('category.name')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type.name')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-map-pin')
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_alcohol_allowed')
                    ->label('Alcohol')
                    ->boolean()
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('minimum_age')
                    ->suffix('+')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->label('Tickets')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('registrations_count')
                    ->counts('registrations')
                    ->label('Registrations')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(EventStatus::class)
                    ->multiple(),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('type')
                    ->relationship('type', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Filter::make('city')
                    ->schema([
                        TextInput::make('city'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['city'],
                            fn($query, $city) => $query->where('city', 'like', "%{$city}%")
                        );
                    }),

                Filter::make('is_alcohol_allowed')
                    ->label('Alcohol Allowed'),

                Filter::make('is_featured')
                    ->label('Featured Event'),

                Filter::make('start_date')
                    ->schema([
                        DatePicker::make('start_from')
                            ->native(false),
                        DatePicker::make('start_until')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['start_from'], fn($query, $date) => $query->whereDate('start_date', '>=', $date))
                            ->when($data['start_until'], fn($query, $date) => $query->whereDate('start_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon(Heroicon::OutlinedArrowPath)
                        ->schema([
                            Select::make('status')
                                ->options(EventStatus::class)
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each(fn($record) => $record->update(['status' => $data['status']]));
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
