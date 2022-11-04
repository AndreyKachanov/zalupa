<?php

namespace App\Models\User;

use App\Traits\EloquentGetTableNameTrait;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * App\Models\User\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $password
 * @property string $email
 * @property string|null $email_verified_at
 * @property int|null $role_id
 * @property string|null $phone
 * @property int $phone_auth
 * @property bool $phone_verified
 * @property string|null $phone_verify_token
 * @property \Illuminate\Support\Carbon|null $phone_verify_token_expire
 * @property string|null $remember_token
 * @property string|null $status
 * @property string|null $verify_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User\Role|null $rRole
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePhoneAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePhoneVerifyToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePhoneVerifyTokenExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereVerifyToken($value)
 * @method static count()
 * @method static create(array $array)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    protected $table = 'users';

    use Notifiable;
    use EloquentGetTableNameTrait;

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'password',
        'verify_token',
        'status',
        'email_verified_at',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone_verify'
    ];

    protected $casts = [
        'phone_verified'            => 'boolean',
        'phone_verify_token_expire' => 'datetime'
    ];

    public static function rolesList(): array
    {
        return [
            self::ROLE_USER      => 'User',
            self::ROLE_MODERATOR => 'Moderator',
            self::ROLE_ADMIN     => 'Admin',
        ];
    }

    public static function register(string $name, string $email, string $password): self
    {
        return static::create([
            'name'         => $name,
            'email'        => $email,
            'password'     => bcrypt($password),
            'verify_token' => Str::uuid(),
            'role'         => self::ROLE_USER,
            'status'       => self::STATUS_WAIT
        ]);
    }

    public static function new($name, $email): self
    {
        return static::create([
            'name'     => $name,
            'email'    => $email,
            'password' => bcrypt(Str::random()),
            'role'     => self::ROLE_USER,
            'status'   => self::STATUS_ACTIVE
        ]);
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isAdmin()
    {
//        return $this->role === self::ROLE_ADMIN;
        return $this->rRole->name === 'Admin';
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function verify(): void
    {

        if (!$this->isWait()) {
            throw new \DomainException('User is already verified');
        }

        $this->update([
            'status'            => self::STATUS_ACTIVE,
            'verify_token'      => null,
            'email_verified_at' => now()
        ]);
    }

    public function changeRole($role): void
    {
        if (!in_array($role, [self::ROLE_USER, self::ROLE_ADMIN, self::ROLE_MODERATOR], true)) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }

        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned');
        }

        $this->update(['role' => $role]);
    }

    public function unverifyPhone(): void
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
//        $this->phone_auth = false;
        try {
            $this->saveOrFail();
        } catch (\Throwable $e) {
        }
    }

    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new \DomainException('Phone number is empty.');
        }
        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now)) {
            throw new \DomainException('Token is already requested.');
        }
        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000, 99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(300);
        $this->saveOrFail();

        return $this->phone_verify_token;
    }

    public function verifyPhone($token, Carbon $now): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new \DomainException('Incorrect verify token.');
        }
        if ($this->phone_verify_token_expire->lt($now)) {
            throw new \DomainException('Token is expired.');
        }
        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function enablePhoneAuth(): void
    {
        if (!empty($this->phone) && !$this->isPhoneVerified()) {
            throw new \DomainException('Phone number is empty.');
        }
        $this->phone_auth = true;
        $this->saveOrFail();
    }


    public function disablePhoneAuth(): void
    {
        $this->phone_auth = false;
        $this->saveOrFail();
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified;
    }

    public function isPhoneAuthEnabled(): bool
    {
        return (bool)$this->phone_auth;
    }

    public function hasFilledProfile(): bool
    {
        return !empty($this->name) && !empty($this->last_name) && $this->isPhoneVerified();
    }

    public function rRole()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
