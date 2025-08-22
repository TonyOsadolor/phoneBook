<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use App\Enums\AppNotificationEnum;
use Illuminate\Support\Facades\Auth;
use App\Traits\AppNotificationTrait;

class BinComponent extends Component
{
    use AppNotificationTrait;
    use WithPagination;
    
    protected $user;

    /**
     * Mount function
     */
    public function mount()
    {
        $this->user = Auth::user();
    }

    /**
     * Restore Contact
     */
    public function restoreContact($contactId): void
    {
        $contact = \App\Models\Contact::withTrashed()->where('id', $contactId)->first();

        $this->authorize('restore', $contact);

        if ($contact) {
            $contact->restore();
        }

        Flux::modals()->close();

        $msg = 'Contact Restored Successfully';
        $this->notify('success', $msg, AppNotificationEnum::SUCCESS);
    }

    /**
     * Permanently Delete Contact
     */
    public function forceDelete($contactId): void
    {
        $contact = \App\Models\Contact::withTrashed()->where('id', $contactId)->first();

        $this->authorize('forceDelete', $contact);

        if ($contact) {
            $contact->forceDelete();
        }

        Flux::modals()->close();

        $msg = 'Contact Permanently Deleted!';
        $this->notify('success', $msg, AppNotificationEnum::SUCCESS);
    }

    public function render()
    {
        $user = Auth::user();
        $contacts = \App\Models\Contact::withTrashed()->where('user_id', $user->id)
            ->whereNotNull('deleted_at')->orderBy('deleted_at', 'desc')->get();
        $hour = date("H:i");
        
        if($hour <= "11:59"){
            $greetings = "Good Morning...";
            $callOutColor = 'success';
        } elseif($hour <= "16:59") {
            $greetings = "Good Afternoon...";
            $callOutColor = 'warning';
        } else{
            $greetings = "Good Evening...";
            $callOutColor = 'danger';
        }

        return view('livewire.bin-component')->with([
            'greetings' => $greetings,
            'callOutColor' => $callOutColor,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Close Modeal
     */
    public function closeModal(string $name)
    {
        $this->modal($name)->close();
    }
}
