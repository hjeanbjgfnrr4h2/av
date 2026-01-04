<?php

namespace App\Filament\Resources\ActressResource\Pages;

use App\Filament\Resources\ActressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActresses extends ListRecords
{
    protected static string $resource = ActressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
