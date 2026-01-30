<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Enums\EventStatus;
use App\Filament\Resources\EventCategories\EventCategoryResource;
use App\Filament\Resources\EventTypes\EventTypeResource;
use App\Filament\Schemas\Components\SlugInput;
use App\Models\Event;
use App\Models\EventCategory;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(4)
            ->components([
                Group::make([
                    Section::make('Basic Information')
                        ->description('General details about the event')
                        ->schema([
                            TextInput::make('title')
                                ->label('Title')
                                ->placeholder('e.g. Summer Festival 2026')
                                ->required()
                                ->live(onBlur: true)
                                ->maxLength(255),
                            SlugInput::make(),

                            Select::make('event_category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->placeholder('Select a category')
                                ->createOptionForm(fn() => EventCategoryResource::form(new Schema())->getComponents()),

                            Select::make('event_type_id')
                                ->label('Event Type')
                                ->relationship('type', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->placeholder('Select an event type')
                                ->createOptionForm(fn() => EventTypeResource::form(new Schema())->getComponents()),


                        ])
                        ->columns()
                        ->columnSpan(3),


                    Section::make('Description & Content')
                        ->schema([
                            Textarea::make('description')
                                ->label('Description')
                                ->placeholder('Brief summary of the event...')
                                ->rows(4)
                                ->maxLength(500)
                                ->columnSpanFull(),

                            MarkdownEditor::make('content')
                                ->label('Content')
                                ->placeholder('Event content...')
                                ->columnSpanFull(),
                        ])->columnSpan(3),
                    Section::make('Media')
                        ->schema([
                            FileUpload::make('banner')
                                ->label('Banner Image')
                                ->image()
                                ->imageEditor()
                                ->disk('public')
                                ->visibility('public')
                                ->required()
                                ->maxSize(2048)
                                ->directory('banners'),

                            FileUpload::make('images')
                                ->label('Gallery Images')
                                ->image()
                                ->disk('public')
                                ->multiple()
                                ->reorderable()
                                ->required()
                                ->visibility('public')
                                ->imageEditor()
                                ->maxFiles(5)
                                ->maxSize(2048)
                                ->directory('images')
                                ->helperText('Up to 5 images')

                        ])
                        ->columnSpan(1),
                ])->columnSpan(3),

                Group::make([

                    Section::make('Date & Time')
                        ->schema([
                            DateTimePicker::make('start_date')
                                ->label('Event Start Date')
                                ->required()
                                ->seconds(false)
                                ->displayFormat('d/m/Y H:i')
                                ->minDate(now()->format('d/m/Y H:i')),

                            DateTimePicker::make('end_date')
                                ->label('Event End Date')
                                ->required()
                                ->seconds(false)
                                ->displayFormat('d/m/Y H:i')
                                ->after('start_date'),

                            DateTimePicker::make('sales_start_date')
                                ->label('Ticket Sales Start Date')
                                ->seconds(false)
                                ->displayFormat('d/m/Y H:i')
                                ->before('sales_end_date'),

                            DateTimePicker::make('sales_end_date')
                                ->label('Ticket Sales End Date')
                                ->seconds(false)
                                ->displayFormat('d/m/Y H:i')
                                ->before('start_date'),
                        ])
                        ->columnSpan(1),

                    Section::make('Location & Rules')
                        ->schema([
                            TextInput::make('city')
                                ->label('City')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Istanbul'),

                            TextInput::make('district')
                                ->label('District')
                                ->maxLength(100)
                                ->placeholder('Kadikoy'),

                            TextInput::make('minimum_age')
                                ->label('Minimum Age')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(99)
                                ->suffix('years')
                                ->helperText('Enter 0 for no limit')
                                ->default(0),

                            Toggle::make('is_alcohol_allowed')
                                ->label('Alcohol Allowed')
                                ->default(false),
                            Toggle::make('is_featured')
                                ->label('Feature Event')
                                ->default(false),
                        ])
                        ->columnSpan(1),
                ])->columnSpan(1)


            ]);

    }
}
