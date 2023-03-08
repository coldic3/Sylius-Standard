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

namespace App\Provider;

use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RefundPlugin\Provider\RefundUnitTotalProviderInterface;
use Webmozart\Assert\Assert;

final class OrderItemTotalProvider implements RefundUnitTotalProviderInterface
{
    public function __construct(private RepositoryInterface $orderItemRepository)
    {
    }

    public function getRefundUnitTotal(int $id): int
    {
        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemRepository->find($id);
        Assert::notNull($orderItem);

        return $orderItem->getTotal();
    }
}
