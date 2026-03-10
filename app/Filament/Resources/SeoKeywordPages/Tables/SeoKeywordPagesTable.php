<?php

namespace App\Filament\Resources\SeoKeywordPages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeoKeywordPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('keyword')
                    ->label('Ключевая фраза')
                    ->searchable(),
                TextColumn::make('cluster')
                    ->label('Кластер')
                    ->searchable(),
                TextColumn::make('used_for')
                    ->label('Назначение')
                    ->searchable(),
                TextColumn::make('frequency')
                    ->label('Частотность')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Текст абзаца')
                    ->limit(80)
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Активно')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
