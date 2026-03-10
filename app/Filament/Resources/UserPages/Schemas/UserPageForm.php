<?php

namespace App\Filament\Resources\UserPages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class UserPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Например: privacy. Страница будет доступна по адресу /pages/{slug}'),
                RichEditor::make('content')
                    ->label('Контент страницы')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'h2',
                        'h3',
                        'blockquote',
                        'orderedList',
                        'bulletList',
                        'link',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull(),
                TextInput::make('seo_title')
                    ->label('SEO title')
                    ->maxLength(255),
                Textarea::make('seo_description')
                    ->label('SEO description')
                    ->rows(3)
                    ->maxLength(1000),
                Toggle::make('is_published')
                    ->label('Опубликована')
                    ->default(true),
            ]);
    }
}
