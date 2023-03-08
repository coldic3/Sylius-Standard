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

namespace App\Refunder;

use App\Entity\Refund\OrderItemRefund;
use App\Event\ItemRefunded;
use Sylius\RefundPlugin\Creator\RefundCreatorInterface;
use Sylius\RefundPlugin\Filter\UnitRefundFilterInterface;
use Sylius\RefundPlugin\Model\UnitRefundInterface;
use Sylius\RefundPlugin\Refunder\RefunderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OrderItemsRefunder implements RefunderInterface
{
    public function __construct(
        private RefundCreatorInterface $refundCreator,
        private MessageBusInterface $eventBus,
        private UnitRefundFilterInterface $unitRefundFilter,
    ) {
    }

    public function refundFromOrder(array $units, string $orderNumber): int
    {
         $units = $this->unitRefundFilter->filterUnitRefunds($units, OrderItemRefund::class);

        $refundedTotal = 0;

        /** @var UnitRefundInterface $unit */
        foreach ($units as $unit) {
            $this->refundCreator->__invoke(
                $orderNumber,
                $unit->id(),
                $unit->total(),
                $unit->type()
            );

            $refundedTotal += $unit->total();

            $this->eventBus->dispatch(new ItemRefunded($orderNumber, $unit->id(), $unit->total()));
        }

        return $refundedTotal;
    }
}
