<?php

namespace App\Models\Admin\Cart\Order;

use App\Models\Admin\Item\Item;
use App\Traits\EloquentGetTableNameTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\Cart\Order\Order
 *
 * @property int $id
 * @property int $item_id
 * @property int $cnt Количество товара
 * @property int $contact_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Cart\Order\Contact $contact
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @property-read Item $item
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\Admin\Cart\Order\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';
    protected $guarded = ['id'];
    protected $casts = [
        //'created_at'  => 'datetime:d.m.Y',
        //'created_at'  => 'datetime:Y-m-d H:m',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
}
