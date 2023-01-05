<?php

namespace App\Models\Admin\Item;

use App\Models\Admin\Cart\CartItem;
use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\Item\Item
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $article_number
 * @property string|null $price1
 * @property string|null $price2
 * @property string|null $price3
 * @property string|null $img
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Item\Category|null $rCategory
 * @method static \Database\Factories\Admin\Item\ItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereArticleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereLink($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|CartItem[] $rCartItems
 * @property-read int|null $r_cart_items_count
 * @property string|null $price
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice($value)
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Item findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Query\Builder|Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|Item withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Item withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Query\Builder|Item withoutTrashed()
 * @property int $is_new
 * @property int $is_hit
 * @property int $is_bestseller
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIsBestseller($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIsHit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIsNew($value)
 */
class Item extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $table = 'items';

    protected $guarded = ['id'];

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

    protected $casts = [
        'is_new' => 'boolean',
        'is_hit' => 'boolean',
        'is_bestseller' => 'boolean'
    ];

    public function rCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function rCartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'item_id', 'id');
    }
}
