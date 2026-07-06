<?php

namespace App\Filament\Resources\FinderNodeResource\Pages;

use App\Filament\Resources\FinderNodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFinderNodes extends ListRecords
{
    protected static string $resource = FinderNodeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
