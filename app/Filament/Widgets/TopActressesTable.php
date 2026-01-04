<?php

namespace App\Filament\Widgets;

use App\Models\Actress;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopActressesTable extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Actress::query()->orderBy('videos_count', 'desc')->limit(10)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->disk('public')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('nationality'),
                
                Tables\Columns\TextColumn::make('videos_count')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('views_count')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
            ]);
    }
}
