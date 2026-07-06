<?php

namespace App\Filament\Resources\StaticTranslateResource\Pages;

use App\Filament\Resources\StaticTranslateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStaticTranslates extends ListRecords
{
    protected static string $resource = StaticTranslateResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
