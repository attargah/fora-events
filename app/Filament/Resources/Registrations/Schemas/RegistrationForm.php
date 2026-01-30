<?php

namespace App\Filament\Resources\Registrations\Schemas;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\User;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns()
            ->components([
                Section::make('Ticket Informations')->schema([
                    Select::make('event_id')
                        ->label('Event')
                        ->relationship('event', 'title')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->helperText('Select the event this order belongs to.'),

                    Select::make('event_ticket_id')
                        ->label('Ticket')
                        ->required()
                        ->relationship('ticket', 'name')
                        ->searchable()
                        ->preload()
                        ->options(fn(Get $get) => $get('event_id') ? Event::find($get('event_id'))->tickets->pluck('name', 'id') : [])
                        ->reactive()
                        ->helperText('Only tickets from the selected event are shown.')
                        ->afterStateUpdated(function ($state, Set $set, Get $get) {

                            if (!$state) {
                                $set('item_price', 0);
                                $set('quantity', $get('quantity') ?? 1, shouldCallUpdatedHooks: true);
                            }

                            $ticket = EventTicket::find($state);

                            if ($ticket) {
                                $set('item_price', $ticket->price ?? 0);
                                $set('quantity', $get('quantity') ?? 1, shouldCallUpdatedHooks: true);
                            }
                        }),

                ]),


                Section::make('Billing Informations')
                    ->schema([
                        Select::make('user_id')->relationship('user', 'name')->preload()
                            ->reactive()->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if (!$state) {
                                    return;
                                }
                                $user = User::query()->find($state);
                                if ($user) {
                                    $set('name',$user->name);
                                    $set('email',$user->email);
                                    $set('phone',$user->phone);
                                }
                            }),

                        TextInput::make('name')
                            ->label('Customer Name')
                            ->required()
                            ->placeholder('John Doe')
                            ->maxLength(255)
                            ->helperText('Full name of the ticket holder.'),
                        Grid::make()->schema([
                            TextInput::make('email')
                                ->label('Email Address')
                                ->email()
                                ->placeholder('example@example.com')
                                ->required()
                                ->helperText('Confirmation and ticket details will be sent to this email.'),

                            TextInput::make('phone')
                                ->label('Phone Number')
                                ->tel()
                                ->placeholder('0123456789')
                                ->required()
                                ->helperText('Used for contact if there are issues with the order.'),
                        ])

                    ]),
                Section::make('Payment Informations')->schema([

                    Repeater::make('attendees')
                        ->relationship()
                        ->minItems(1)
                        ->table([
                            TableColumn::make('Name')->alignStart(),
                            TableColumn::make('Email Address')->alignStart(),
                            TableColumn::make('Phone Number')->alignStart(),
                        ])
                        ->schema([
                            TextInput::make('name')
                                ->label('Attendee Name')
                                ->placeholder('John Doe')
                                ->required(),
                            TextInput::make('email')
                                ->label('Attendee Email')
                                ->placeholder('example@example.com')
                                ->required()
                                ->email(),
                            TextInput::make('phone')
                                ->label('Attendee Phone')
                                ->placeholder('0123456789')
                                ->required()
                                ->tel(),
                        ])->afterStateUpdated(function ($state, Set $set) {
                            $quantity = is_array($state) ? count($state) : 0;
                            $set('quantity', $quantity, shouldCallUpdatedHooks: true);
                        })
                        ->maxItems(function (Get $get) {
                            $ticket = $get('event_ticket_id');

                            if (empty($ticket)) {
                                return null;
                            }

                            $ticket = EventTicket::find($ticket);

                            return $ticket->max_tickets_per_person > 0 ? $ticket->max_tickets_per_person : null;
                        })->deletable(fn ($state) => is_array($state) and count($state) > 1)
                        ->columnSpanFull()
                        ->addActionLabel('Add Attendee'),

                    Fieldset::make('Totals')
                        ->columns(3)
                        ->schema([
                            TextInput::make('item_price')
                                ->label('Ticket Price')
                                ->numeric()
                                ->placeholder('0.00')
                                ->prefix('$')
                                ->readOnly(),

                            TextInput::make('quantity')
                                ->label('Quantity')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->reactive()
                                ->readOnly()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $set('total_price', ($get('item_price') ?? 0) * ($state ?? 1));
                                }),

                            TextInput::make('total_price')
                                ->label('Total Price')
                                ->numeric()
                                ->placeholder('0.00')
                                ->prefix('$')
                                ->readOnly(),
                        ]),


                ])->columnSpanFull(),

            ]);
    }
}
