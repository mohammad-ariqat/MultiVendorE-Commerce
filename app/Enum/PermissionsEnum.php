<?php

namespace App\Enum;

enum PermissionsEnum : string
{
    case ApproveVendors = 'approve-vendors';
    case SellProducts = 'sell-products';
    case BuyProducts = 'buy-products';
}

?>
