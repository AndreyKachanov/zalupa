<?php

namespace App\Models\Admin\Item;

use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * App\Models\Item\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Item\Item[] $rItems
 * @property-read int|null $r_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Item\Item[] $items
 * @property-read int|null $items_count
 * @property int|null $parent_id
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Admin\Item\Item|null $latestContact
 * @property-read \App\Models\Admin\Item\Item|null $mostPrice
 * @property-read \App\Models\Admin\Item\Item|null $mostPriceArticleNumber
 * @property-read \App\Models\Admin\Item\Item|null $oldestContact
 * @method static \Illuminate\Database\Eloquent\Builder|Category findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @property string|null $img
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImg($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category treeOf(callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @property int|null $sorting
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Category whereSorting($value)
 */
class Category extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use HasRecursiveRelationships;

    protected $table = 'items_categories';

    protected $guarded = ['id'];
    protected $casts = ['parent_id' => 'integer'];

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
    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }

    public function latestContact()
    {
        return $this->hasOne(Item::class, 'category_id', 'id')->latestOfMany();
    }

    public function oldestContact()
    {
        return $this->hasOne(Item::class, 'category_id', 'id')->oldestOfMany();
    }

    public function mostPrice()
    {
        return $this->hasOne(Item::class, 'category_id', 'id')->ofMany('price', 'max');
    }

    public function mostPriceArticleNumber(): HasOne
    {
        return $this->hasOne(Item::class, 'category_id', 'id')->ofMany([
            'price' => 'max'
        ], function ($query) {
            $query->whereArticleNumber('22363');
        });
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function recursiveItems(): \Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\HasManyOfDescendants
    {
        //return $this->hasManyOfDescendantsAndSelf(Item::class);
        return $this->hasManyOfDescendants(Item::class);
    }

    //public function recursiveItemsNotSelf(): \Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\HasManyOfDescendants
    //{
    //    return $this->hasManyOfDescendants(Item::class);
    //}
}
