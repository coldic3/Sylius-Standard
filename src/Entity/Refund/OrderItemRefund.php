<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity\Refund;

use Sylius\RefundPlugin\Model\UnitRefundInterface;

final class OrderItemRefund implements UnitRefundInterface
{
    public function __construct(private int $itemId, private int $total)
    {
    }

    public function id(): int
    {
        return $this->itemId;
    }

    public function total(): int
    {
        return $this->total;
    }

    public static function type(): RefundType
    {
        return RefundType::orderItem();
    }
}
