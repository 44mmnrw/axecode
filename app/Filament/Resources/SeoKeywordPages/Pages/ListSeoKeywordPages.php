<?php

namespace App\Filament\Resources\SeoKeywordPages\Pages;

use App\Filament\Resources\SeoKeywordPages\SeoKeywordPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeoKeywordPages extends ListRecords
{
    protected static string $resource = SeoKeywordPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
