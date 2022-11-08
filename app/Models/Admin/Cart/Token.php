<?php

namespace App\Models\Admin\Cart;

use App\Traits\EloquentGetTableNameTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use EloquentGetTableNameTrait;
    use HasFactory;

    protected $table = 'carts_tokens';
    protected $guarded = ['id'];
}
