<?php

namespace App\Filament\Resources\SeoKeywordPages\Pages;

use App\Filament\Resources\SeoKeywordPages\SeoKeywordPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSeoKeywordPage extends EditRecord
{
    protected static string $resource = SeoKeywordPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
