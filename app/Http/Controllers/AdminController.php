<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function messages()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages', compact('messages'));
    }

    public function deleteMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        return redirect()->route('admin.messages')->with('success', 'Сообщение удалено');
    }

    public function analyticsSettings()
    {
        $yandexId = Setting::get('yandex_metrika_id');
        $googleId  = Setting::get('google_analytics_id');
        return view('admin.analytics', compact('yandexId', 'googleId'));
    }

    public function saveAnalyticsSettings(Request $request)
    {
        $request->validate([
            'yandex_metrika_id'   => ['nullable', 'regex:/^\d{5,10}$/'],
            'google_analytics_id' => ['nullable', 'regex:/^G-[A-Z0-9]{4,12}$/'],
        ], [
            'yandex_metrika_id.regex'   => 'ID Яндекс Метрики должен содержать только цифры (5–10 символов)',
            'google_analytics_id.regex' => 'Google Measurement ID должен быть в формате G-XXXXXXXXXX',
        ]);

        Setting::set('yandex_metrika_id',   $request->input('yandex_metrika_id', ''));
        Setting::set('google_analytics_id', $request->input('google_analytics_id', ''));

        return redirect()->route('admin.analytics')->with('success', 'Настройки аналитики сохранены');
    }

    public function privacyPage()
    {
        $content = Setting::get('privacy_policy');
        return view('admin.privacy', compact('content'));
    }

    public function savePrivacyPage(Request $request)
    {
        $request->validate([
            'privacy_policy' => ['nullable', 'string', 'max:100000'],
        ]);

        Setting::set('privacy_policy', $request->input('privacy_policy', ''));

        return redirect()->route('admin.privacy')->with('success', 'Политика конфиденциальности сохранена');
    }
}
