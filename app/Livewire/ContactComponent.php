<?php

namespace App\Livewire;

use Flux\Flux;
use App\Models\Date;
use App\Models\Email;
use App\Models\Contact;
use Livewire\Component;
use App\Models\PhoneNumber;
use Livewire\WithPagination;
use App\Enums\ContactTypeEnum;
use App\Enums\AppNotificationEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Traits\AppNotificationTrait;

class ContactComponent extends Component
{
    use AppNotificationTrait;
    use WithPagination;

    /**
     * Handle an incoming task request.
     */   
    public string $first_name = '';
    public string $last_name = '';
    public string $phonecode = '';
    public string $phone = '';
    public string $email = '';
    public string $date = '';

    /**
     * Save New Contacts
     */
    public function addContact(): void
    {
        $user = Auth::user();

        $this->authorize('create', Contact::class);

        $validated = $this->validate(
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required_without:first_name', 'string', 'max:255'],
                'phonecode' => ['required_with:phone', 'string'],
                'phone' => ['required_without:email', 'numeric'],
                'email' => ['required_without:phone', 'string', 'lowercase', 'email', 'max:90'],
                'date' => ['nullable', 'date'],
            ],
            [
                'first_name.required' => 'First Name is Required',
                'last_name.required_without' => 'First Name is Required',
                'phonecode.required_with' => 'Enter Country Code',
                'phone.required_without' => 'Phone number is needed email is not present.',
                'phone.numeric' => 'numbers only.',
                'email.required_without' => 'Email is needed phone number is not present.',
                'date.date' => 'Provide a valid date.',
            ]
        );

        $contact = Contact::create([
            'user_id' => $user->id,
            'first_name' => isset($validated['first_name']) ? $validated['first_name'] :null,
            'last_name' => isset($validated['last_name']) ? $validated['last_name'] :null,
        ]);

        $this->storeDependencies($contact, $validated);
        
        $this->reset();
        Flux::modal('add-new-contact')->close();
        $msg = 'Contact Added Successfully';
        $this->notify('success', $msg, AppNotificationEnum::SUCCESS);
    }

    /**
     * Update Contact
     */ 
    public string $update_phonecode;
    public function updateContact(Contact $contact): void
    {
        $data = $this->validate([
            'update_first_name' => ['nullable', 'string'],
            'update_last_name' => ['nullable', 'string'],
            'update_phone' => ['nullable', 'string'],
            'update_phonecode' => ['nullable', 'string'],
            'update_email' => ['nullable', 'email'],
            'update_date' => ['nullable', 'string'],
        ]);

        $this->authorize('update', $contact);

        $contact->update([
            'first_name' => $data['update_first_name'] != null ? $data['update_first_name'] : null,
            'last_name' => $data['update_last_name'] != null ? $data['update_last_name'] : null,
        ]);

        $this->updateDependencies($contact, $data);
        
        $this->reset();
        Flux::modals()->close();
        $msg = 'Contact Updated Successfully';
        $this->notify('success', $msg, AppNotificationEnum::SUCCESS);
    }

    /**
     * Render View
     */
    public function render()
    {
        $user = Auth::user();
        $contacts = \App\Models\Contact::where('user_id', $user->id)->orderBy('first_name')->get();
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

        return view('livewire.contact-component')->with([
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

    /**
     * Update Dependencies
     */
    public function updateDependencies(Contact $contact, $data): void
    {
        // Update Phone Number
        if (isset($data['update_phone']) && $data['update_phone'] != null) {
            $phoneNumber = str_starts_with($data['update_phone'], '+') ? $data['update_phone'] : $data['update_phonecode']. $data['update_phone'];
            $phone = PhoneNumber::where('contact_id', $contact->id)->first();
            
            if ($phone && $phone->number != $phoneNumber) {
                $phone->update(['number' => $phoneNumber]);
            } else {
                PhoneNumber::create([
                    'contact_id' => $contact->id,
                    'number' => $phoneNumber,
                ]);
            }
        }

        // Update Email
        if (isset($data['update_email']) && $data['update_email'] != null) {
            $emailAddress = $data['update_email'];
            $email = Email::where('contact_id', $contact->id)->first();
            
            if ($email && $email->email != $emailAddress) {
                $phone->update(['email' => $emailAddress]);
            } else {
                Email::create([
                    'contact_id' => $contact->id,
                    'email' => $emailAddress,
                ]);
            }
        }

        // Update Date
        if (isset($data['update_date']) && $data['update_date'] != null) {
            $updateDate = $data['update_date'];
            $date = Date::where('contact_id', $contact->id)->first();
            
            if ($date && $date->date != $updateDate) {
                $date->update(['date' => $updateDate]);
            } else {
                Date::create([
                    'contact_id' => $contact->id,
                    'date' => $updateDate,
                ]);
            }
        }
    }

    /**
     * Edit Contact
     */
    public string $update_first_name = '';
    public string $update_last_name = '';
    public string $update_phone = '';
    public string $update_email = '';
    public string $update_date = '';
    public function editContact(int $contactId)
    {
        $contact = Contact::find($contactId);

        $this->update_first_name = $contact->first_name ? $contact->first_name : '';
        $this->update_last_name = $contact->last_name ? $contact->last_name : '';
        $this->update_phone = $contact->phonenumber ? $contact->phonenumber->number : '';
        $this->update_email = $contact->email ? $contact->email->email : '';
        $this->update_date = $contact->date ? $contact->date->date : '';

    }

    /**
     * Delete Contact
     */
    public function deleteContact(Contact $contact): void
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        Flux::modals()->close();

        $msg = 'Contact Deleted Successfully';
        $this->notify('success', $msg, AppNotificationEnum::SUCCESS);
    }

    /**
     * Store Dependencies
     */
    public function storeDependencies(Contact $contact, $data): void
    {
        if (isset($data['phone']) && $data['phone'] != null) {
            PhoneNumber::create([
                'contact_id' => $contact->id,
                'number' => $data['phonecode'] .$data['phone'],
                'label' => ContactTypeEnum::MOBILE,
            ]);
        }
        if (isset($data['email']) && $data['email'] != null) {
            Email::create([
                'contact_id' => $contact->id,
                'email' => $data['email'],
                'label' => ContactTypeEnum::MOBILE,
            ]);
        }
        if (isset($data['date']) && $data['date'] != null) {
            Date::create([
                'contact_id' => $contact->id,
                'date' => $data['date'],
                'label' => ContactTypeEnum::BIRTHDAY,
            ]);
        }
    }
}
