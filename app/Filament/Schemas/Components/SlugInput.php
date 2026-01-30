<?php

namespace App\Filament\Schemas\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;

class SlugInput extends TextInput
{


    public static function make(string|null $name = 'slug',string|null $titleField = 'title'): static
    {

        return parent::make($name)
            ->label('Slug')
            ->helperText('Use the button right of the input to generate slug from title')
            ->required()
            ->readOnly()
            ->maxLength(255)
            ->rules(['alpha_dash'])
            ->unique(ignoreRecord: true)
            ->suffixAction(
                Action::make('makeSlug')
                    ->label('Generate Slug')
                    ->icon(Heroicon::OutlinedLink)
                    ->action(function (Set $set, Get $get,$model) use ($titleField,$name)  {

                        if (! $model) {
                            return;
                        }

                        $set(
                            $name,
                            $model::createSlug(
                                $get($titleField)
                            )
                        );
                    })
            );
    }





}
