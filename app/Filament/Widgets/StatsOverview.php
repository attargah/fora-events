<?php

namespace App\Filament\Widgets;

use App\Enums\CheckoutStatus;
use App\Enums\EventStatus;
use App\Filament\Resources\Checkouts\CheckoutResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Registrations\RegistrationResource;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Checkout;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return Cache::remember('stats_overview', now()->addMinutes(5), function () {
            $totalEvents = Event::count();
            $activeEvents = Event::where('status', EventStatus::Active)->count();
            $totalRegistrations = Registration::count();
            $totalRevenue = Checkout::where('status', CheckoutStatus::Completed)->sum('total');
            $activePercentage = $totalEvents > 0 ? round(($activeEvents / $totalEvents) * 100) : 0;

            return [
                Stat::make('Total Events', $totalEvents)
                    ->description($activeEvents . ' active events')
                    ->descriptionIcon(Heroicon::OutlinedChartPie)
                    ->color('success')
                    ->url(EventResource::getUrl('index')),

                Stat::make('Total Registrations', number_format($totalRegistrations))
                    ->description('All time registrations')
                    ->descriptionIcon(Heroicon::OutlinedUserGroup)
                    ->color('info')
                    ->url(RegistrationResource::getUrl('index')),

                Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                    ->description('Completed checkouts')
                    ->descriptionIcon(Heroicon::OutlinedCurrencyDollar)
                    ->color('warning')
                    ->url(CheckoutResource::getUrl('index')),

                Stat::make('Active Events', $activeEvents)
                    ->description($activePercentage . '% of all events')
                    ->descriptionIcon(Heroicon::CheckCircle)
                    ->color('primary')
                    ->url(EventResource::getUrl('index')),
            ];
        });
    }
}
