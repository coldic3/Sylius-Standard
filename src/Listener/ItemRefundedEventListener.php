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

namespace App\Listener;

use App\Event\ItemRefunded;
use Sylius\RefundPlugin\StateResolver\OrderPartiallyRefundedStateResolverInterface;

final class ItemRefundedEventListener
{
    public function __construct(private OrderPartiallyRefundedStateResolverInterface $orderPartiallyRefundedStateResolver)
    {
    }

    public function __invoke(ItemRefunded $itemRefunded): void
    {
        $this->orderPartiallyRefundedStateResolver->resolve($itemRefunded->orderNumber());
    }
}
