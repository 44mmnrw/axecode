<?php

namespace App\Filament\Resources\UserPages\Pages;

use App\Filament\Resources\UserPages\UserPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserPages extends ListRecords
{
    protected static string $resource = UserPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
