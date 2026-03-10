<?php

namespace App\Filament\Resources\SeoKeywordPages\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SeoKeywordPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('keyword')
                    ->label('Ключевая фраза')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('cluster')
                    ->label('Кластер')
                    ->required()
                    ->maxLength(255),

                TextInput::make('used_for')
                    ->label('Что используется / назначение')
                    ->required()
                    ->maxLength(255),

                TextInput::make('frequency')
                    ->label('Частотность')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                TextInput::make('title')
                    ->label('Title')
                    ->maxLength(255),

                TextInput::make('h1')
                    ->label('H1')
                    ->maxLength(255),

                TextInput::make('h2')
                    ->label('H2')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Текст абзаца (человекопонятный)')
                    ->helperText('Используется в блоке: <p class="text-gray-300 text-lg mt-6 max-w-3xl">')
                    ->rows(4)
                    ->maxLength(2000)
                    ->columnSpanFull(),

                TextInput::make('meta_title')
                    ->label('Meta title')
                    ->maxLength(255),

                Textarea::make('meta_description')
                    ->label('Meta description')
                    ->rows(3)
                    ->maxLength(2000),

                Textarea::make('meta_keywords')
                    ->label('Meta keywords')
                    ->rows(3)
                    ->maxLength(2000),

                KeyValue::make('meta_fields')
                    ->label('Дополнительные meta-поля')
                    ->keyLabel('Ключ')
                    ->valueLabel('Значение')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Активно')
                    ->default(true),
            ]);
    }
}
