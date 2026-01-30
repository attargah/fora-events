<?php

namespace App\Filament\Widgets;


use App\Filament\Resources\Registrations\RegistrationResource;
use App\Models\Registration;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Cache;

class RecentRegistrations extends BaseWidget
{
    protected static ?string $heading = 'Recent Registrations';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $cachedRegistrations = Cache::remember('recent_registrations', now()->addMinutes(5), function () {
            return Registration::query()
                ->with(['event', 'ticket'])
                ->latest()
                ->limit(10)
                ->get();
        });

        return $table->recordUrl(fn ($record) => RegistrationResource::getUrl('edit', ['record' => $record]))
            ->query(
                Registration::query()
                    ->whereIn('id', $cachedRegistrations->pluck('id'))
                    ->with(['event', 'ticket'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('ticket.name')
                    ->label('Ticket Name')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('view_all')
                ->label('View All Registrations')
                ->url(RegistrationResource::getUrl('index')),
        ];
    }
}
