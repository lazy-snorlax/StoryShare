<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\User\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use App\Support\Enums\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * @property-read \App\Models\Role $role
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'two_factor_required',
        'two_factor_method_preferred',
        'two_factor_method_enabled',
        'two_factor_secret',
        'terms_agreed_at',
        'privacy_policy_agreed_at',
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
        'email_verified_at' => 'immutable_datetime',
        'status' => UserStatus::class,
    ];

    /**
     * A user has a role through the assigned roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function role(): HasOneThrough
    {
        return $this->hasOneThrough(Role::class, AssignedRole::class, 'entity_id', 'id', 'id', 'role_id')
            ->where('assigned_roles.entity_type', self::class);
    }

    public function loadAbilities(): self
    {
        $this->setRelation('abilities', $this->abilities->merge($this->role?->abilities ?? []));
        return $this;
    }

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

    public function profile() {
        return $this->hasOne(Profile::class);
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


    /**
     * A user can have many bookmarks
     * 
     * @return 
     */
    public function bookmarks() : HasMany
    {
        return $this->hasMany(Bookmark::class);
    }


    /**
     * A user can applaud many stories
     * 
     * @return 
     */
    public function applause() : HasMany
    {
        return $this->hasMany(Applause::class);
    }

    /**
     * Return all the user's abilities and if they have explicitly been
     * forbidden from having an ability, then we return with a forbidden flag
     * set to true. Unfortunately bouncer doesn't have a method for returning
     * all abilities, forbidden or not
     */
    public function getUserAbilities()
    {
        $abilities = $this->getAbilities()->merge($this->getForbiddenAbilities());

        $abilities->each(function ($ability) {
            $ability->forbidden = $this->getForbiddenAbilities()->contains($ability);
        });

        return $abilities;
    }
}
