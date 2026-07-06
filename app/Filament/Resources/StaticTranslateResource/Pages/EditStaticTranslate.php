<?php

namespace App\Filament\Resources\StaticTranslateResource\Pages;

use App\Filament\Resources\StaticTranslateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStaticTranslate extends EditRecord
{
    protected static string $resource = StaticTranslateResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
