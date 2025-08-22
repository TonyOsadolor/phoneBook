<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The dates for attributes that should be treated as dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Boot for Creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * The appended attributes for the model.
     *
     * @var array
     */
    protected $appends = ['contact_full_name'];

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getContactFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the user that owns the contact.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contacts for the user.
     */
    public function phonenumber(): HasOne
    {
        return $this->hasONe(PhoneNumber::class);
    }

    /**
     * Get the contacts for the user.
     */
    public function email(): HasOne
    {
        return $this->hasONe(Email::class);
    }

    /**
     * Get the contacts for the user.
     */
    public function date(): HasOne
    {
        return $this->hasONe(Date::class);
    }
}
