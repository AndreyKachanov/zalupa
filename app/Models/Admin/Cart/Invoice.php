<?php

namespace App\Models\Admin\Cart;

use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Cart\Invoice
 *
 * @property int $id
 * @property string $bill_number
 * @property int $token_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Cart\Token $token
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;

    protected $table = 'invoices';
    protected $guarded = ['id'];

    //public static function boot()
    //{
    //    parent::boot();
    //    static::creating(function ($invoice) {
    //        dd(1);
    //    });
    //}
    //public function token()
    //{
    //    return $this->belongsTo(Token::class, 'token_id', 'id');
    //}

    //public function invoice()
    //{
    //    return $this->hasOne(Invoice::class);
    //}

    public function token()
    {
        return $this->belongsTo(Token::class, 'token_id', 'id');
    }
}
