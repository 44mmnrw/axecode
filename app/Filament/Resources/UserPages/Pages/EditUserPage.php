<?php

namespace App\Filament\Resources\UserPages\Pages;

use App\Filament\Resources\UserPages\UserPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserPage extends EditRecord
{
    protected static string $resource = UserPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
