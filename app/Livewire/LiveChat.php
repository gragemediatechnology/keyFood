<?php

// namespace App\Livewire;

// use App\Models\LiveChat as ModelsLiveChat;
// use App\Models\User;
// use Illuminate\Contracts\Database\Eloquent\Builder;
// use Livewire\Component;
// use Livewire\WithFileUploads;
// use Illuminate\Http\Request;

// class LiveChat extends Component
// {
//     use WithFileUploads;

//     public User $user;
//     public $message = '';
//     public $images;

//     public function render()
//     {
//         $messages = ModelsLiveChat::where(function (Builder $query) {
//             $query->where('from_user_id', auth()->id())
//                 ->where('to_user_id', $this->user->id);
//         })
//         ->orWhere(function (Builder $query) {
//             $query->where('from_user_id', $this->user->id)
//                 ->where('to_user_id', auth()->id());
//         })
//         ->orderBy('created_at', 'asc')
//         ->get();

//         // Mark messages as read
//         $messages->where('from_user_id', $this->user->id)
//                  ->where('is_read', false)
//                  ->each->markAsRead();

//         return view('livewire.live-chat', [
//             'messages' => $messages,
//         ]);
//     }

//     public function SendMessage(Request $request)
//     {
//         $path = null;
//         // dd($request->image);
//         dd($request->hasFile('images'), $this->message, $request->all());

//         // $this->validate([
//         //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,mp4|max:10000',
//         // ]);

//         if ($this->images) {
//             $path = $this->images->storeAs('img/chats', $this->images->getClientOriginalName(), 'public');
//         }

//         ModelsLiveChat::create([
//             'from_user_id' => auth()->id(),
//             'to_user_id' => $this->user->id,
//             'message' => $this->message,
//             'image' => $path,
//             'ip_address' => $request->ip(),
//         ]);

//         $this->message = '';
//         $this->images = null;
//     }
// }


namespace App\Livewire;

use App\Models\LiveChat as ModelsLiveChat;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;

class LiveChat extends Component
{
    use WithFileUploads;

    public User $user;
    public $message = '';
    public $image;

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

    public function SendMessage(Request $request)
    {
        // dd($request->all());
        $path = null;

        $this->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,mp4|max:10000',
        ]);

        if ($this->image) {
            $path = $this->image->storeAs('img/chats', $this->image->getClientOriginalName(), 'public');
        }

        ModelsLiveChat::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $this->user->id,
            'message' => $this->message,
            'image' => $path,
            'ip_address' => $request->ip(),
        ]);

        $this->message = '';
        $this->image = null;
    }
}

