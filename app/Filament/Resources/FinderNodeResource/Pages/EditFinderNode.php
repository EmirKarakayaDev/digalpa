<?php

namespace App\Filament\Resources\FinderNodeResource\Pages;

use App\Filament\Resources\FinderNodeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFinderNode extends EditRecord
{
    protected static string $resource = FinderNodeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
