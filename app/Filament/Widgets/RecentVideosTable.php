<?php

namespace App\Filament\Widgets;

use App\Models\Video;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentVideosTable extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Video::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->square(),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('channel.name'),
                
                Tables\Columns\TextColumn::make('views_count')
                    ->numeric(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime(),
            ]);
    }
}
