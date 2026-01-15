<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // Сохранить в БД
            ContactMessage::create($validated);

            // TODO: Отправить письмо на hello@axecode.tech (настроить SMTP в .env)
            // Mail::to(config('mail.from.address'))->send(new ContactFormMail($validated));

            return response()->json([
                'success' => true,
                'message' => 'Спасибо! Ваше сообщение получено. Мы скоро с вами свяжемся.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Contact form error', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке сообщения. Попробуйте позже.'
            ], 500);
        }
    }
}

