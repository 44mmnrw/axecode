<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Throwable;
use UnitEnum;

class PrivacySettings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Политика конфиденциальности';

    protected static ?string $title = 'Политика конфиденциальности';

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected string $view = 'filament.pages.privacy-settings';

    public string $editorDataJson = '';

    public function mount(): void
    {
        $storedEditorJson = (string) Setting::get('privacy_policy_editorjs', '');

        if ($storedEditorJson !== '') {
            $this->editorDataJson = $storedEditorJson;
            return;
        }

        $legacyHtml = (string) Setting::get('privacy_policy', '');
        $plainText = trim(strip_tags($legacyHtml));

        $this->editorDataJson = json_encode([
            'time' => now()->timestamp,
            'blocks' => [
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $plainText !== '' ? e($plainText) : 'Введите текст политики конфиденциальности...',
                    ],
                ],
            ],
            'version' => '2.30.0',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{"blocks":[]}';
    }

    public function save(?string $editorDataJson = null): void
    {
        try {
            if ($editorDataJson !== null) {
                $this->editorDataJson = $editorDataJson;
            }

            $this->validate([
                'editorDataJson' => ['required', 'string', 'max:500000'],
            ]);

            $editorData = json_decode($this->editorDataJson, true);
            if (!is_array($editorData) || !isset($editorData['blocks']) || !is_array($editorData['blocks'])) {
                Notification::make()
                    ->title('Некорректный формат данных редактора')
                    ->danger()
                    ->send();

                return;
            }

            $html = $this->renderEditorJsToHtml($editorData['blocks']);

            Setting::set('privacy_policy_editorjs', $this->editorDataJson);
            Setting::set('privacy_policy', $html);

            Notification::make()
                ->title('Политика конфиденциальности сохранена')
                ->success()
                ->send();

            // Важно: не перерисовываем компонент после save,
            // иначе Livewire морфинг может визуально откатить состояние Editor.js.
            $this->skipRender();
        } catch (Throwable) {
            Notification::make()
                ->title('Ошибка сохранения политики')
                ->body('Попробуйте ещё раз. Если ошибка повторится — обновите страницу.')
                ->danger()
                ->send();
        }
    }

    private function renderEditorJsToHtml(array $blocks): string
    {
        $result = [];

        foreach ($blocks as $block) {
            $type = Arr::get($block, 'type');
            $data = Arr::get($block, 'data', []);

            if (!is_string($type) || !is_array($data)) {
                continue;
            }

            $html = match ($type) {
                'header' => $this->renderHeader($data),
                'paragraph' => $this->renderParagraph($data),
                'list' => $this->renderList($data),
                'quote' => $this->renderQuote($data),
                'delimiter' => '<hr>',
                default => $this->renderParagraph($data),
            };

            if ($html !== '') {
                $result[] = $html;
            }
        }

        return (new HtmlString(implode(PHP_EOL, $result)))->toHtml();
    }

    private function renderHeader(array $data): string
    {
        $level = (int) Arr::get($data, 'level', 2);
        $level = max(1, min(4, $level));
        $text = trim((string) Arr::get($data, 'text', ''));

        return $text !== '' ? "<h{$level}>{$text}</h{$level}>" : '';
    }

    private function renderParagraph(array $data): string
    {
        $text = trim((string) Arr::get($data, 'text', ''));

        return $text !== '' ? "<p>{$text}</p>" : '';
    }

    private function renderList(array $data): string
    {
        $style = (string) Arr::get($data, 'style', 'unordered');
        $items = Arr::get($data, 'items', []);

        if (!is_array($items) || count($items) === 0) {
            return '';
        }

        return $this->renderListItems($items, $style);
    }

    private function renderListItems(array $items, string $style = 'unordered'): string
    {
        $tag = $style === 'ordered' ? 'ol' : 'ul';

        $li = collect($items)
            ->map(function ($item) use ($style) {
                if (is_string($item)) {
                    $content = trim($item);

                    return $content !== '' ? '<li>' . $content . '</li>' : '';
                }

                if (!is_array($item)) {
                    return '';
                }

                $content = trim((string) Arr::get($item, 'content', Arr::get($item, 'text', '')));
                $nestedItems = Arr::get($item, 'items', []);
                $nested = is_array($nestedItems) && count($nestedItems)
                    ? $this->renderListItems($nestedItems, $style)
                    : '';

                if ($content === '' && $nested === '') {
                    return '';
                }

                return '<li>' . $content . $nested . '</li>';
            })
            ->filter(fn ($item) => $item !== '')
            ->implode('');

        return $li !== '' ? "<{$tag}>{$li}</{$tag}>" : '';
    }

    private function renderQuote(array $data): string
    {
        $text = trim((string) Arr::get($data, 'text', ''));
        $caption = trim((string) Arr::get($data, 'caption', ''));

        if ($text === '') {
            return '';
        }

        $captionHtml = $caption !== '' ? "<cite>{$caption}</cite>" : '';

        return "<blockquote><p>{$text}</p>{$captionHtml}</blockquote>";
    }
}
