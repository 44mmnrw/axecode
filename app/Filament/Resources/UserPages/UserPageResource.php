<?php

namespace App\Filament\Resources\UserPages;

use App\Filament\Resources\UserPages\Pages\CreateUserPage;
use App\Filament\Resources\UserPages\Pages\EditUserPage;
use App\Filament\Resources\UserPages\Pages\ListUserPages;
use App\Filament\Resources\UserPages\Schemas\UserPageForm;
use App\Filament\Resources\UserPages\Tables\UserPagesTable;
use App\Models\UserPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class UserPageResource extends Resource
{
    protected static ?string $model = UserPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Пользовательские страницы';

    protected static ?string $modelLabel = 'Пользовательская страница';

    protected static ?string $pluralModelLabel = 'Пользовательские страницы';

    protected static string|UnitEnum|null $navigationGroup = 'Контент';

    public static function form(Schema $schema): Schema
    {
        return UserPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserPagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserPages::route('/'),
            'create' => CreateUserPage::route('/create'),
            'edit' => EditUserPage::route('/{record}/edit'),
        ];
    }
}
