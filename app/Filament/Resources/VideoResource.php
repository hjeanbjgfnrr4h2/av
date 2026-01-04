<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Video Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255),
                        
                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('video_url')
                            ->url()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('duration')
                            ->placeholder('HH:MM:SS')
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('thumbnails')
                            ->maxSize(2048),
                        
                        Forms\Components\FileUpload::make('poster_image')
                            ->image()
                            ->disk('public')
                            ->directory('posters')
                            ->maxSize(2048),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Relationships')
                    ->schema([
                        Forms\Components\Select::make('channel_id')
                            ->relationship('channel', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description'),
                            ]),
                        
                        Forms\Components\Select::make('actresses')
                            ->relationship('actresses', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        
                        Forms\Components\Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        
                        Forms\Components\TagsInput::make('tags')
                            ->relationship('tags', 'name')
                            ->splitKeys(['Tab', ','])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.1)
                            ->default(0),
                        
                        Forms\Components\Toggle::make('is_censored')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                        
                        Forms\Components\DateTimePicker::make('published_at')
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->square(),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('channel.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('views_count')
                    ->sortable()
                    ->numeric(),
                
                Tables\Columns\TextColumn::make('favorites_count')
                    ->sortable()
                    ->numeric(),
                
                Tables\Columns\TextColumn::make('rating')
                    ->sortable()
                    ->numeric(decimalPlaces: 2),
                
                Tables\Columns\IconColumn::make('is_censored')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_censored')
                    ->options([
                        1 => 'Censored',
                        0 => 'Uncensored',
                    ]),
                
                Tables\Filters\SelectFilter::make('is_featured')
                    ->options([
                        1 => 'Featured',
                        0 => 'Not Featured',
                    ]),
                
                Tables\Filters\SelectFilter::make('channel')
                    ->relationship('channel', 'name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from'),
                        Forms\Components\DatePicker::make('published_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['published_from'], fn ($q, $date) => $q->whereDate('published_at', '>=', $date))
                            ->when($data['published_until'], fn ($q, $date) => $q->whereDate('published_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
            'view' => Pages\ViewVideo::route('/{record}'),
        ];
    }
}
