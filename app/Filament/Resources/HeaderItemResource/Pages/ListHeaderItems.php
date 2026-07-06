<?php

namespace App\Filament\Resources\HeaderItemResource\Pages;

use App\Filament\Resources\HeaderItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeaderItems extends ListRecords
{
    protected static string $resource = HeaderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
