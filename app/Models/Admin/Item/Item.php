<?php

namespace App\Models\Admin\Item;

use App\Models\Admin\Cart\CartItem;
use App\Models\Admin\Cart\Order\Order;
use App\Models\Admin\Setting;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * App\Models\Admin\Item\Item
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $note
 * @property string|null $slug
 * @property string|null $article_number
 * @property int|null $price
 * @property int|null $min_order_amount
 * @property string|null $img
 * @property bool $is_new
 * @property bool $is_hit
 * @property bool $is_bestseller
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CartItem> $cartItems
 * @property-read int|null $cart_items_count
 * @property-read \App\Models\Admin\Item\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @method static \Database\Factories\Admin\Item\ItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Item findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereArticleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIsBestseller($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIsHit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIsNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereMinOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Item withoutTrashed()
 * @mixin \Eloquent
 */
class Item extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $table = 'items';
    protected $guarded = ['id'];
    protected $casts = [
        'is_new' => 'boolean',
        'is_hit' => 'boolean',
        'is_bestseller' => 'boolean'
    ];

    /**
     * @return \string[][]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'item_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->HasMany(Order::class);
    }


    protected function price(): Attribute
    {
        return Attribute::make(
            //get: fn ($value) => ($value / 100) * (int)Setting::firstWhere('prop_key', 'price_increase')->prop_value + $value
            get: function ($value) {
                //myCacheFunction - функция кеширования, чтобы не дергалась бд много раз.
                $priceIncrease = myCacheFunction(
                    'price_increase',
                    fn() => Setting::firstWhere('prop_key', 'price_increase')->prop_value
                );
                return round( ($value / 100) * (int)$priceIncrease + $value);
            }
        );
    }
}
