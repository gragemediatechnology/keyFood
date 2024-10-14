<?php

// 



namespace App\Livewire;

use App\Models\LiveChat as ModelsLiveChat;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;




class LiveChat extends Component
{
    use WithFileUploads;

    public User $user;
    public $message = '';
    public $image;
    public $messageSent = false;

    protected $rules = [
        'message' => 'required|string|max:255',
        'image' => 'nullable|image|max:1024', // max 1MB
    ];

    public function render()
    {
        $messages = ModelsLiveChat::where(function (Builder $query) {
            $query->where('from_user_id', auth()->id())
                ->where('to_user_id', $this->user->id);
        })
        ->orWhere(function (Builder $query) {
            $query->where('from_user_id', $this->user->id)
                ->where('to_user_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        $messages->where('from_user_id', $this->user->id)
                 ->where('is_read', false)
                 ->each->markAsRead();

        return view('livewire.live-chat', [
            'messages' => $messages,
        ]);
    }

    public function SendMessage()
    {
        $this->validate();

        $path = null;

        if ($this->image) {
            $path = $this->image->store('public/img/chats');
            $path = Storage::url($path);
        }

        ModelsLiveChat::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $this->user->id,
            'message' => $this->message,
            'image' => $path,
            'ip_address' => request()->ip(),
        ]);

        $this->reset(['message', 'image']);
        $this->messageSent = true;
    }

    public function getListeners()
    {
        return [
            'echo:private-chat.' . auth()->id() . ',MessageSent' => 'refreshMessages',
        ];
    }

    public function refreshMessages()
    {
        // This method will be called when a new message is received
        // The component will re-render automatically
    }
}