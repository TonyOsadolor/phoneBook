<p align="center"><a href="https://github.com/TonyOsadolor/phoneBook" target="_blank"><img src="https://tinnovations.com.ng/public_icons/contacts.png" width="200" height="auto"></a></p>

## About Project => Phone Book

PhoneBook is a WebApp that helps users manage their phone contacts, 
by providing a full CRUD using Laravel Framework 12.25.0 with it out of the box 
features of LiveWire, Flux and a bit of FlowBite.

### Stacks

- **Backend : PHP / Laravel**
- **Frontend : HTML - Blade, Flux, Flowbite**

## Setup Guide
##### Setting up your workspace
##### Laravel Version => '12.25.0'
Before running this app locally make sure you have the following software installed:
<ul>
    <li>XAMPP/WAMP/LAMP or it's equivalent</li>
    <li>NPM [Node]</li>
    <li>Composer</li>
    <li>A Web Browser</li>
</ul>
Now, follow this steps:
<ol>
    <li>Go to https://github.com/TonyOsadolor/phoneBook .</li>
    <li>Open your terminal, navigate to your preferred folder and Run: <code>git clone https://github.com/TonyOsadolor/phoneBook.git</code>.</li>
    <li>Run <code>composer install</code></li>
    <li>Run <code>npm install</code></li>
    <li>Run <code>npm run dev</code> or <code>npm run build</code></li>
    <li>Copy all the contents of the <code>.env.example</code> file. Create <code>.env</code> file and paste all the contents you copied from <code>.env.exmaple</code> file to your <code>.env</code> file.</li>
    <li>Run <code>php artisan key:generate --show</code> to retrieve a base64 encoded string; copy same and past in the Laravel's APP_KEY in <code>.env</code> or run <code>php artisan key:generate</code> to have the key generated and attach itself.</li>
    <li>Set your DB_DATABASE = <code>phonebook</code></li>
    <li>If you are using XAMPP, run it as an administrator. Start Apache and Mysql. Go to <code>localhost/phpmyadmin</code> and create new database and name it <code>phonebook</code>.</li>
    <li>If you use any other offline server client, simply setup your local database name <code>phonebook</code>.</li>
    <li>Once you are done with the database set up, kindly run <code>php artisan migrate</code>.</li>
    <li>When you are done migrating the tables, run <code>php artisan db:seed</code> to see the default record of required data.</li>
    <li>Run php artisan serve from your terminal to start your local server at: <code>http://127.0.0.1:8000/</code> .</li>
    <li>Open your web browser and visit: <code>http://127.0.0.1:8000/</code> to get started .</li>
</ol>

## Documentation Guide
##### Documentation for the Project
Basic feature of the App built with Laravel Classes includes:
<ol>
    <li>Enum Classes <code>for Uniform naming</code></li>
    <li>LiveWire Classes</li>
    <li>LiveWire Blade Templates</li>
    <li>Traits <code>for running under the hood tasks [NOT for Jobs and Queued Schedules]</code></li>
    <li>Policies <code>This handles security of Models to ensure the right access by owners</code></li>
</ol>

##### Registration and Login
Upon Successful Registration a verification code is sent to the registered email, 
for the purpose of this project and testing, this is sent as in verification link, 
once clicked it verifies the user, and then the user can access all 'verified' protected routes.

##### Users Guide [Routes]
<ul>
    <li>Register=> <code>/register</code></li>
    <li>Login => <code>/login</code></li>
    <li>Dashboard => <code>/dashboard</code></li>
    <li>Settings <code>/settings</code></li>
    <li>Bin <code>/bin</code></li>
    <li>Add new Contact => <code>uses Flux Modal and Livewire function</code></li>
    <li>View Contact => <code>uses Flux Modal and Livewire function</code></li>
    <li>Edit Contact => <code>uses Flux Modal and Livewire function</code></li>
    <li>Delete Contact => <code>uses Flux Modal and Livewire function</code></li>
    <li>Restore Contact => <code>uses Flux Modal and Livewire function</code></li>
</ul>

##### Registration
The following fields are required for user's Registration
<ul>
    <li>'first_name' => First Name</li>
    <li>'last_name' => Last Name</li>
    <li>'username' => unique username for each user</li>
    <li>'email' => unique email address for each user</li>
    <li>'phone' => unique phone number for each user</li>
    <li>'password' => to secure their account.</li>
</ul>

##### Login
Since we are using same route for login all that is required is:
 - Email address registered on the system
 - Password to the account provided

##### LiveWire Component Classes
This is used for the basic App interactions

##### LiveWire Blade View Template
This hold the basic HTML structures of the WebApp

##### UI/UX [LiveWire, Flux & FlowBite]
The UI of the App was handled with Flux, LiveWire and a bit of 
FlowBite, to substitute for some Flux features which required paid version to use.

##### Model Policies
This helps to restrict access to only owners of record for CRUD operations

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
