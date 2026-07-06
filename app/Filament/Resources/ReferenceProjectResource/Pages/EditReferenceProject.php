<?php

namespace App\Filament\Resources\ReferenceProjectResource\Pages;

use App\Filament\Resources\ReferenceProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferenceProject extends EditRecord
{
    protected static string $resource = ReferenceProjectResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
