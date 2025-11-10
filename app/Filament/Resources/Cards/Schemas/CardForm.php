<?php

namespace App\Filament\Resources\Cards\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required()
                ->columnSpanFull(),

            SpatieMediaLibraryFileUpload::make('image')
                ->image()
                ->imageEditor()
                ->columnSpanFull(),

            SpatieTagsInput::make('tags')
                ->columnSpanFull(),

            Textarea::make('text')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            Textarea::make('summary_en')
                ->label('Summary (English)')
                ->rows(3)
                ->columnSpanFull(),

            Textarea::make('summary_es')
                ->label('Summary (Spanish)')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }
}
