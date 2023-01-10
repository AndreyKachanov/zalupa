<?php

namespace App\Models\Admin\Cart\Order;

use App\Models\Admin\Cart\Token;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\Cart\Order\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $contact
 * @property int $token_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Cart\Order\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Token $token
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $email
 * @method static \Database\Factories\Admin\Cart\Order\ContactFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @property string $city
 * @property string $street
 * @property string $house_number
 * @property string $transport_company
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereTransportCompany($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withoutTrashed()
 */
class Contact extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders_contacts';
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'contact_id', 'id');
    }

    public function token()
    {
        return $this->belongsTo(Token::class, 'token_id', 'id');
    }
}
