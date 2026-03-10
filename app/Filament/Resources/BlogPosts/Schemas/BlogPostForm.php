<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\BlogCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Категория')
                    ->options(BlogCategory::query()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Textarea::make('excerpt')
                    ->label('Краткое описание')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Содержимое')
                    ->required()
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
                    ->label('Опубликован')
                    ->default(false),
                DateTimePicker::make('published_at')
                    ->label('Дата публикации'),
            ]);
    }
}
