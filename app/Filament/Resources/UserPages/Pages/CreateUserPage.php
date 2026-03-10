<?php

namespace App\Filament\Resources\UserPages\Pages;

use App\Filament\Resources\UserPages\UserPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserPage extends CreateRecord
{
    protected static string $resource = UserPageResource::class;
}
