<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ChatBox extends Component
{
    public $selectedUser;
    public $messages = [];
    public $body;

    // protected $listeners = ['chatSelected'];
    #[On('chatSelected')]
    public function chatSelected($userId)
    {
        $this->body = '';
        $this->selectedUser = User::where('id', $userId)->get()->first();
        $this->messages = Message::where(function ($q) use ($userId) {
            $q->where('from_id', Auth::id())
                ->where('to_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('from_id', $userId)
                ->where('to_id', Auth::id());
        })->orderBy('created_at')->get();
    }

    public function sendMessage()
    {
        // dd($this->body);
        if ($this->body) {

            Message::create([
                'from_id' => Auth::id(),
                'to_id' => $this->selectedUser->id,
                'body' => $this->body
            ]);
            $this->reset(['body']);

            // Reload messages after sending
            // $this->chatSelected($this->selectedUser->id);
            $this->dispatch('clearInput');
        }
    }
    public function sayHey($body)
    {
        Message::create([
            'from_id' => Auth::id(),
            'to_id' => $this->selectedUser->id,
            'body' => $body
        ]);
        $this->reset(['body']);
        $this->dispatch('clearInput');
    }
    public function render()
    {
        if ($this->selectedUser) {
            $userId = $this->selectedUser->id;
            $this->messages = Message::where(function ($q) use ($userId) {
                $q->where('from_id', Auth::id())
                    ->where('to_id', $userId);
            })->orWhere(function ($q) use ($userId) {
                $q->where('from_id', $userId)
                    ->where('to_id', Auth::id());
            })->orderBy('created_at')->get();
        }
        return view('livewire.chat-box');
    }
}
