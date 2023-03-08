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

class RefundType extends \Sylius\RefundPlugin\Model\RefundType
{
    public const ORDER_ITEM = 'order_item';

    public static function orderItem(): self
    {
        return new self(self::ORDER_ITEM);
    }
}
