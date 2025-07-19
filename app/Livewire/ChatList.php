<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $id;
    public $contacts;

    public function selected($user)
    {
        $this->id = $user;
        $this->dispatch('chatSelected', [$user]);
    }

    public function updated()
    {
        $authId = Auth::id();

        $this->contacts = User::where('id', '!=', $authId)
            ->get()
            ->map(function ($user) use ($authId) {
                $lastMessage = Message::where(function ($q) use ($user, $authId) {
                    $q->where('from_id', $authId)->where('to_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user, $authId) {
                        $q->where('from_id', $user->id)->where('to_id', $authId);
                    })
                    ->latest()
                    ->first();
                if ($lastMessage) {
                    $user->from = $lastMessage->from_id === $authId ? 'You' : Str::before($user->name, ': ');
                } else {
                    $user->from = '';
                }
                $user->last_message = $lastMessage?->body ?? 'No messages yet!';
                $user->last_time = $lastMessage?->created_at?->diffForHumans() ?? '';
                return $user;
            });
    }

    public function render()
    {
        $authId = Auth::id();

        $this->contacts  = User::where('id', '!=', $authId)
            ->get()
            ->map(function ($user) use ($authId) {
                $lastMessage = Message::where(function ($q) use ($user, $authId) {
                    $q->where('from_id', $authId)->where('to_id', $user->id);
                })
                    ->orWhere(function ($q) use ($user, $authId) {
                        $q->where('from_id', $user->id)->where('to_id', $authId);
                    })
                    ->latest()
                    ->first();
                if ($lastMessage) {
                    $user->from = $lastMessage->from_id === $authId ? 'You' : Str::before($user->name . '', ' ');
                } else {
                    $user->from = '';
                }
                $user->last_message = $lastMessage?->body ?? 'No messages yet!';
                $user->last_time = $lastMessage?->created_at?->diffForHumans() ?? '';
                return $user;
            });

        return view('livewire.chat-list', $this->contacts);
    }
}
