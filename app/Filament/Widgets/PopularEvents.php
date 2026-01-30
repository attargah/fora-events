<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Events\EventResource;
use App\Models\Event;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Cache;

class PopularEvents extends BaseWidget
{
    protected static ?string $heading = 'Most Popular Events';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $cachedEvents = Cache::remember('popular_events', now()->addMinutes(5), function () {
            return Event::query()
                ->withCount('registrations')
                ->orderBy('registrations_count', 'desc')
                ->limit(10)
                ->get();
        });

        return $table->recordUrl(fn ($record) => EventResource::getUrl('edit', ['record' => $record]))
            ->query(
                Event::query()->whereIn('id', $cachedEvents->pluck('id'))
                    ->withCount('registrations')
                    ->orderBy('registrations_count', 'desc')
            )
            ->columns([
                ImageColumn::make('banner')
                    ->label('Banner'),

                TextColumn::make('title')
                    ->label('Event Title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Event Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('registrations_count')
                    ->label('Registrations')
                    ->alignCenter()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('city')
                    ->label('Location')
                    ->formatStateUsing(fn ($record) => $record->city . ($record->district ? ', ' . $record->district : ''))
                    ->sortable(),
            ])
            ->defaultSort('registrations_count', 'desc');
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('view_all')
                ->label('View All Events')
                ->url(EventResource::getUrl('index')),
        ];
    }
}
