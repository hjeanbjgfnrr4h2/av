<?php

namespace App\Filament\Resources\ActressResource\Pages;

use App\Filament\Resources\ActressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActress extends EditRecord
{
    protected static string $resource = ActressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
