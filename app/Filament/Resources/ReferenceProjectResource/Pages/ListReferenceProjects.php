<?php

namespace App\Filament\Resources\ReferenceProjectResource\Pages;

use App\Filament\Resources\ReferenceProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferenceProjects extends ListRecords
{
    protected static string $resource = ReferenceProjectResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
