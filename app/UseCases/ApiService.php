<?php

namespace App\UseCases;

use App\Models\Admin\Cart\Invoice;

class ApiService
{
    public function getInvoiceNumber(): string
    {
        return 'pre-2022-' . str_pad(Invoice::max('id') + 1, 5, '0', STR_PAD_LEFT);
    }
}
