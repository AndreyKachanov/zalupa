<?php

namespace App\Models\Admin\Item;

use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 */
class Category extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;

    protected $table = 'items_categories';

    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function rItems(): HasMany
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }
}
