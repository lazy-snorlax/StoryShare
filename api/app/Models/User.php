<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Password attribute caster.
     */
    public function password(): Attribute
    {
        return new Attribute(set: fn ($value) => $value ? bcrypt($value) : null);
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Email verification signature parameters.
     *
     * Used to generate and validate the signature when verifying a users email.
     *
     * @return array
     */
    public function emailVerificationSignatureParameters(): array
    {
        return [
            'id' => $this->getKey(),
            'hash' => sha1($this->getEmailForVerification()),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * A user can have many stories
     * 
     * @return 
     */
    public function stories() : HasMany
    {
        return $this->hasMany(Story::class);
    }
}
