<?php

namespace App\Filament\Resources\SeoKeywordPages;

use App\Filament\Resources\SeoKeywordPages\Pages\CreateSeoKeywordPage;
use App\Filament\Resources\SeoKeywordPages\Pages\EditSeoKeywordPage;
use App\Filament\Resources\SeoKeywordPages\Pages\ListSeoKeywordPages;
use App\Filament\Resources\SeoKeywordPages\Schemas\SeoKeywordPageForm;
use App\Filament\Resources\SeoKeywordPages\Tables\SeoKeywordPagesTable;
use App\Models\SeoKeywordPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SeoKeywordPageResource extends Resource
{
    protected static ?string $model = SeoKeywordPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'SEO ключи и кластеры';

    protected static ?string $modelLabel = 'SEO ключ';

    protected static ?string $pluralModelLabel = 'SEO ключи';

    protected static string|UnitEnum|null $navigationGroup = 'SEO';

    public static function form(Schema $schema): Schema
    {
        return SeoKeywordPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeoKeywordPagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeoKeywordPages::route('/'),
            'create' => CreateSeoKeywordPage::route('/create'),
            'edit' => EditSeoKeywordPage::route('/{record}/edit'),
        ];
    }
}
