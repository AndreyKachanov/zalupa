<?php

namespace App\Models\Admin\Cart;

use App\Models\Admin\Cart\Order\Contact;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * App\Models\Admin\Cart\Token
 *
 * @property int $id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Cart\CartItem[] $rCartItems
 * @property-read int|null $r_cart_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Token newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token query()
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $ip
 * @method static \Illuminate\Database\Eloquent\Builder|Token whereIp($value)
 * @property-read \App\Models\Admin\Cart\Invoice|null $invoice
 * @property-read Contact $contact
 * @property-read int|null $invoice_count
 */
class Token extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;

    protected $table = 'carts_tokens';
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rCartItems()
    {
        //return $this->hasMany(Cart::class, 'token_id', 'id')->select('item_id as id', 'cnt');
        return $this->hasMany(CartItem::class, 'token_id', 'id')->select('item_id as id', 'cnt');
    }

    //public function invoices()
    //{
    //    return $this->hasMany(Invoice::class, 'token_id', 'id');
    //}

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'token_id', 'id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'token_id', 'id');
    }
}
