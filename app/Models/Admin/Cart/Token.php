<?php

namespace App\Models\Admin\Cart;

use App\Models\Admin\Cart\Order\Contact;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * App\Models\Admin\Cart\Token
 *
 * @property int $id
 * @property string $token
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $cart_items_count
 * @property-read Contact|null $contact
 * @property-read \App\Models\Admin\Cart\Invoice|null $invoice
 * @method static \Database\Factories\Admin\Cart\TokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Token newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token query()
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Cart\CartItem> $cartItems
 * @mixin \Eloquent
 */
class Token extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;

    protected $table = 'carts_tokens';
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'token_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'token_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class, 'token_id', 'id');
    }
}
