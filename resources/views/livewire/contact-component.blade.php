<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <!-- Greetings Banner Starts -->
            <flux:callout icon="check-circle" variant="{{$callOutColor}}" inline>
                <flux:callout.heading><i>{{$greetings}}</i> <h3 class="text-center">{{ auth()->user()->full_name }}</h3></flux:callout.heading>
                <flux:callout.text>What would you like to do today?</flux:callout.text>

                <x-slot name="actions">
                    <flux:modal.trigger name="add-new-contact">
                        <flux:button variant="primary">Add New Contact?</flux:button>
                    </flux:modal.trigger>
                </x-slot>
            </flux:callout>
            <!-- Greetings Banner End -->
        </div>

        @if ($contacts && count($contacts) > 0)
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                S/N
                            </th>
                            <th scope="col" class="px-6 py-3">
                                NAMES
                            </th>
                            <th scope="col" class="px-6 py-3">
                                PHONE
                            </th>
                            <th scope="col" class="px-6 py-3">
                                EMAIL
                            </th>
                            <th scope="col" class="px-6 py-3">
                                VIEW
                            </th>
                        </tr>
                    </thead>
                    <?php $sn = 1; ?>
                    @foreach($contacts as $contact)
                    <tbody class="text-center">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4">
                                {{ $sn }}
                            </td>
                            <td class="px-6 py-4">
                                {{ optional($contact)->contact_full_name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ optional($contact)->phonenumber->number ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ optional($contact)->email->email ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <flux:modal.trigger name="viewContact-{{$contact->id}}">
                                    <flux:button>View Contact</flux:button>
                                </flux:modal.trigger>
                            </td>
                        </tr>
                    </tbody>
                    <?php $sn++; ?>
                    
                    <!-- View Contact Starts -->
                    <flux:modal :name="'viewContact-'.$contact->id">
                        <div class="text-center align-items-center">
                            <flux:heading size="lg">View {{ $contact->contact_full_name }}</flux:heading>
                        </div>
                        <flux:separator />
                        <hr style="border: 2px solid transparent;margin:1%;">
                        <form>
                            <div class="grid gap-12 sm:grid-cols-2 sm:gap-12 w-96">
                                <div class="w-full">
                                    <flux:heading size="lg">First Name</flux:heading>
                                    <flux:text class="mt-2">{{ optional($contact)->first_name ?? 'N/A' }}</flux:text>
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Last Name</flux:heading>
                                    <flux:text class="mt-2">{{ optional($contact)->last_name ?? 'N/A' }}</flux:text>
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Phone Number</flux:heading>
                                    <flux:text class="mt-2">{{ optional($contact)->phonenumber->number ?? 'N/A' }}</flux:text>
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Email</flux:heading>
                                    <flux:text class="mt-2">{{ optional($contact)->email->email ?? 'N/A' }}</flux:text>
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Important Date</flux:heading>
                                    <flux:text class="mt-2">{{ optional($contact)->date->date ?? 'N/A' }}</flux:text>
                                </div>
                            </div>
                            
                            <hr style="border: 2px solid transparent;margin:1%;">
                            <flux:separator />
                            <hr style="border: 2px solid transparent;margin:1%;">

                            <flux:modal.close>
                                <flux:button variant="primary" color="rose" wire:click="closeModal('viewContact-{{$contact->id}}')" icon="x-circle">Close Contact</flux:button>
                            </flux:modal.close>
                            <flux:modal.trigger name="editContact-{{$contact->id}}" wire:click="editContact({{ $contact->id }})">
                                <flux:button variant="primary" color="green" icon="pencil-square">Update Contact</flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="confirmDelete({{$contact->id}})">
                                <flux:button variant="danger" color="red" icon="trash">Delete Contact</flux:button>
                            </flux:modal.trigger>
                        </form>
                    </flux:modal>
                    <!-- View Contact Ends -->

                    <!-- Edit Contact Starts -->
                    <flux:modal :name="'editContact-'.$contact->id" wire:key="editContact{{ $contact->id }}">
                        <div class="text-center align-items-center">
                            <flux:heading size="lg">Edit {{ $contact->contact_full_name }}</flux:heading>
                        </div>
                        <flux:separator />
                        <hr style="border: 2px solid transparent;margin:1%;">
                        <form wire:submit="updateContact({{$contact->id}})">
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="w-full">
                                    <flux:heading size="lg">First Name</flux:heading>
                                    <flux:input wire:model="update_first_name" />
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Last Name</flux:heading>
                                    <flux:input wire:model="update_last_name" />
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Country Code</flux:heading>
                                    <flux:select wire:model="update_phonecode" placeholder="Choose country...">
                                        @foreach (\App\Models\Country::where('is_active', 1)->get() as $country)
                                            <flux:select.option value="+{{ $country->phonecode }}">{{ $country->name }} [+{{ $country->phonecode }}]</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Update Phone</flux:heading>
                                    <flux:input wire:model="update_phone" />
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Update Email</flux:heading>
                                    <flux:input wire:model="update_email" />
                                </div>

                                <div class="w-full">
                                    <flux:heading size="lg">Update Date</flux:heading>
                                    <flux:input wire:model="update_date" />
                                </div>
                            </div>
                            
                            <hr style="border: 2px solid transparent;margin:1%;">
                            <flux:separator />
                            <hr style="border: 2px solid transparent;margin:1%;">

                            <flux:modal.close>
                                <flux:button variant="primary" color="rose" wire:click="closeModal('editContact-{{$contact->id}}')" icon="x-circle">Close Contact</flux:button>
                            </flux:modal.close>
                            <flux:modal.close>
                                <flux:button variant="primary" color="green" wire:click="updateContact({{ $contact->id }})" icon="eye">Update Contact</flux:button>
                            </flux:modal.close>
                        </form>
                    </flux:modal>
                    <!-- Edit Contact Ends -->

                    <!-- Delete Contact Starts -->
                    <flux:modal name="confirmDelete({{$contact->id}})" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Delete Contact?</flux:heading>

                                <flux:text class="mt-2">
                                    <p>You're about to delete this contact.</p>
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost" wire:click="closeModal('confirmDelete({{$contact->id}})')">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button wire:click="deleteContact({{$contact->id}})" variant="danger" color="red" icon="trash">Delete Contact</flux:button>
                            </div>
                        </div>
                    </flux:modal>
                    <!-- Delete Contact Ends -->
                    @endforeach
                </table>
                {{-- {{ $contacts->links() }} --}}
            </div>
        </div>        
        @else
        <div id="toast-success" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                </svg>
                <span class="sr-only">Warning icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">No Contacts</div>
        </div>
        @endif
    </div>

    <!-- Add New Task Modal Starts --> 
    <flux:modal name="add-new-contact" id="add-new-contact">
        <div class="space-y-6 space-x-6">
            <div>
                <flux:heading size="lg">Add New Contact</flux:heading>
                <flux:text class="mt-2">Enter new Contact Details</flux:text>
            </div>
            
            <form wire:submit="addContact">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="w-full">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <input type="text" id="first_name" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="John" 
                            wire:model="first_name" autocomplete="off"/>
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400"><span class="font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                        <input type="text" id="last_name" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Doe" 
                            wire:model="last_name" autocomplete="off"/>
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400"><span class="font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="phonecode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a Country</label>
                        <select 
                            id="phonecode" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                wire:model="phonecode">
                            <option selected>Choose a Category</option>
                            @foreach (\App\Models\Country::where('is_active', 1)->get() as $country)
                                <flux:select.option value="+{{ $country->phonecode }}">{{ $country->name }} [+{{ $country->phonecode }}]</flux:select.option>
                            @endforeach
                        </select>
                        @error('phonecode')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400"><span class="font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                        <input type="text" id="phone" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="9033987418" 
                            wire:model="phone" autocomplete="off"/>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400"><span class="font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="text" id="email" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="mail@emai.com" 
                            wire:model="email" autocomplete="off"/>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400"><span class="font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Important Date</label>
                        <input type="date" id="date" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="mail@emai" 
                            wire:model="date" autocomplete="off"/>
                        @error('date')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400"><span class="font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <hr style="margin:2% auto; border:2px solid transparent;">

                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="relative">
                        <button type="submit" wire:loading.attr="disabled" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>

                    <div class="relative" wire:loading wire:target="addContact">
                        <div role="status">
                            <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span class="sr-only" wire:loading wire:target="addContact">Adding...</span>
                        </div>
                    </div>
                </div>

            </form>

            <flux:modal.close>
                <flux:button variant="danger" wire:click="closeModal('add-new-contact')">Close</flux:button>
            </flux:modal.close>

        </div>
    </flux:modal>
    <!-- Add New Task Modal Stops -->
</div>
