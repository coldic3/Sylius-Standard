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

namespace App\Event;

class ItemRefunded
{
    public function __construct(private string $orderNumber, private int $itemId, private int $amount)
    {
    }

    public function orderNumber(): string
    {
        return $this->orderNumber;
    }

    public function itemId(): int
    {
        return $this->itemId;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
