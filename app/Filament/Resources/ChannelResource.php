<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChannelResource\Pages;
use App\Filament\Resources\ChannelResource\RelationManagers\VideosRelationManager;
use App\Models\Channel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ChannelResource extends Resource
{
    protected static ?string $model = Channel::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('logos')
                    ->maxSize(1024),
                
                Forms\Components\FileUpload::make('banner')
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->maxSize(2048),
                
                Forms\Components\Toggle::make('is_verified')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->disk('public')
                    ->square(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('videos_count')
                    ->sortable()
                    ->numeric(),
                
                Tables\Columns\TextColumn::make('subscribers_count')
                    ->sortable()
                    ->numeric(),
                
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_verified')
                    ->options([
                        1 => 'Verified',
                        0 => 'Not Verified',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VideosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChannels::route('/'),
            'create' => Pages\CreateChannel::route('/create'),
            'edit' => Pages\EditChannel::route('/{record}/edit'),
        ];
    }
}
