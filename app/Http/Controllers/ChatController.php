<?php

namespace App\Http\Controllers;

use App\Models\MensajePrivado;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function show(Request $request, User $recipient): View
    {
        $userId = $request->user()->id;

        $messages = MensajePrivado::query()
            ->where(function ($query) use ($userId, $recipient): void {
                $query->where('id_emisor', $userId)
                    ->where('id_receptor', $recipient->id);
            })
            ->orWhere(function ($query) use ($userId, $recipient): void {
                $query->where('id_emisor', $recipient->id)
                    ->where('id_receptor', $userId);
            })
            ->orderBy('fecha_envio')
            ->get();

        MensajePrivado::query()
            ->where('id_emisor', $recipient->id)
            ->where('id_receptor', $userId)
            ->where('leido', false)
            ->update(['leido' => true]);

        return view('pages.auth.chat', compact('messages', 'recipient'));
    }

    public function store(Request $request, User $recipient): RedirectResponse
    {
        $validated = $request->validate([
            'contenido' => ['required', 'string', 'max:5000'],
        ]);

        if ($request->user()->is($recipient)) {
            return back()->withErrors(['contenido' => __('You cannot send a message to yourself.')]);
        }

        MensajePrivado::query()->create([
            'id_emisor' => $request->user()->id,
            'id_receptor' => $recipient->id,
            'contenido' => $validated['contenido'],
            'leido' => false,
        ]);

        return to_route('chat.show', $recipient);
    }
}
