<?php

namespace App\Filament\Resources\HeaderItemResource\Pages;

use App\Filament\Resources\HeaderItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeaderItem extends EditRecord
{
    protected static string $resource = HeaderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
