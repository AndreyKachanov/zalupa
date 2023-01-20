<?php

namespace App\Models\Admin\Cart;

use App\Models\Admin\Item\Item;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\Cart\Cart
 *
 * @property int $id
 * @property int|null $token_id
 * @property int|null $item_id
 * @property int|null $cnt Количество товара
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Cart\Token|null $rToken
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Item $rItem
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|CartItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CartItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CartItem withoutTrashed()
 */
class CartItem extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'carts_items';
    protected $guarded = ['id'];
    protected $casts = ['cnt' => 'integer'];

    public function rToken()
    {
        return $this->belongsTo(Token::class, 'token_id', 'id');
    }
    public function rItem()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
