<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        // Fetch unread notifications for the current admin user
        $this->notifications = Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['read' => true]);
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.notifications', [
            'notifications' => $this->notifications,
        ]);
    }
}
