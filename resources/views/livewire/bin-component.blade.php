<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <!-- Greetings Banner Starts -->
            <flux:callout icon="check-circle" variant="{{$callOutColor}}" inline>
                <flux:callout.heading><i>{{$greetings}}</i> <h3 class="text-center">{{ auth()->user()->full_name }}</h3></flux:callout.heading>
                <flux:callout.text>What would you like to do today?</flux:callout.text>
            </flux:callout>
            <!-- Greetings Banner End -->
        </div>

        <div style="margin: 1% auto;text-align:center;">
            <h2 style="color:whitesmoke; text-decoration:underline;font-weight:bold;">
                Bin: Deleted Contacts
            </h2>
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
                            <th scope="col" class="px-6 py-3">
                                DATE
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
                            <td class="px-6 py-4">
                                {{ optional($contact)->deleted_at->diffForHumans() ?? 'N/A' }}
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
                                <flux:button variant="danger" color="red" wire:click="closeModal('viewContact-{{$contact->id}}')" icon="x-circle">Close</flux:button>
                            </flux:modal.close>
                            <flux:modal.trigger name="restoreContact({{$contact->id}})">
                                <flux:button variant="primary" color="green" icon="arrow-path">Restore Contact</flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="forceDelete({{$contact->id}})">
                                <flux:button variant="danger" color="red" icon="trash">Delete Contact</flux:button>
                            </flux:modal.trigger>
                        </form>
                    </flux:modal>
                    <!-- View Contact Ends -->

                    <!-- Restore Contact Starts -->
                    <flux:modal name="restoreContact({{$contact->id}})" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Resotre Contact?</flux:heading>

                                <flux:text class="mt-2">
                                    <p>You're about to restore this contact.</p>
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost" wire:click="closeModal('confirmDelete({{$contact->id}})')">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button wire:click="restoreContact({{$contact->id}})" variant="primary" color="green" icon="arrow-path">Restore Contact</flux:button>
                            </div>
                        </div>
                    </flux:modal>
                    <!-- Restore Contact Ends -->

                    <!-- Delete Contact Starts -->
                    <flux:modal name="forceDelete({{$contact->id}})" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Delete Contact?</flux:heading>

                                <flux:text class="mt-2">
                                    <p>You're about to permanently delete this contact.</p>
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost" wire:click="closeModal('forceDelete({{$contact->id}})')">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button wire:click="forceDelete({{$contact->id}})" variant="danger" color="red" icon="trash">Delete Permanently</flux:button>
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
            <div class="ms-3 text-sm font-normal">No Deleted Contacts</div>
        </div>
        @endif
    </div>
</div>
