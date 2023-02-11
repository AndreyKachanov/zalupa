<?php

namespace App\UseCases;

use App\Models\Admin\Cart\Invoice;

class ApiService
{
    public function getInvoiceNumber(): string
    {
        return date('Y') . '-' . str_pad(Invoice::max('id') * 33, 6, '0', STR_PAD_LEFT);
    }
}
