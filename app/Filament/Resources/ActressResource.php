<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActressResource\Pages;
use App\Filament\Resources\ActressResource\RelationManagers\VideosRelationManager;
use App\Models\Actress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ActressResource extends Resource
{
    protected static ?string $model = Actress::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
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
                        
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->disk('public')
                            ->directory('avatars')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                        
                        Forms\Components\RichEditor::make('bio')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Details')
                    ->schema([
                        Forms\Components\DatePicker::make('birthdate')
                            ->native(false),
                        
                        Forms\Components\TextInput::make('nationality')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('height')
                            ->numeric()
                            ->suffix('cm'),
                        
                        Forms\Components\TextInput::make('measurements')
                            ->maxLength(255),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->disk('public')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('nationality')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('videos_count')
                    ->sortable()
                    ->numeric(),
                
                Tables\Columns\TextColumn::make('views_count')
                    ->sortable()
                    ->numeric(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('nationality')
                    ->searchable(),
                
                Tables\Filters\SelectFilter::make('is_featured')
                    ->options([
                        1 => 'Featured',
                        0 => 'Not Featured',
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
            'index' => Pages\ListActresses::route('/'),
            'create' => Pages\CreateActress::route('/create'),
            'edit' => Pages\EditActress::route('/{record}/edit'),
        ];
    }
}
