<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Field::configureUsing(fn($field) => $field->translateLabel());
        Column::configureUsing(fn($field) => $field->translateLabel());
        SelectFilter::configureUsing(fn($field) => $field->translateLabel());
        TextColumn::configureUsing(fn(TextColumn $column) => $column->sortable());

        Table::configureUsing(fn(Table $table) => $table
            ->striped()
            ->paginationPageOptions([25, 50, 100]));
    }
}
