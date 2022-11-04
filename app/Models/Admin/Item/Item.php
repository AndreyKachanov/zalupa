<?php

namespace App\Models\Admin\Item;

use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\Administration\FlightFactory;

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
 */
class Item extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;

    protected $table = 'items';

    protected $guarded = ['id'];

    public function rCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
