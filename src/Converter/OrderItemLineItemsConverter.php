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

namespace App\Converter;

use App\Entity\Refund\OrderItemRefund;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RefundPlugin\Converter\LineItemsConverterUnitRefundAwareInterface;
use Sylius\RefundPlugin\Entity\LineItem;
use Sylius\RefundPlugin\Entity\LineItemInterface;
use Sylius\RefundPlugin\Provider\TaxRateProviderInterface;
use Webmozart\Assert\Assert;

final class OrderItemLineItemsConverter implements LineItemsConverterUnitRefundAwareInterface
{
    public function __construct(
        private RepositoryInterface $orderItemRepository,
        private TaxRateProviderInterface $taxRateProvider
    ) {
    }

    public function convert(array $units): array
    {
        Assert::allIsInstanceOf($units, $this->getUnitRefundClass());

        $lineItems = [];

        /** @var OrderItemRefund $unit */
        foreach ($units as $unit) {
            $lineItems = $this->addLineItem($this->convertUnitRefundToLineItem($unit), $lineItems);
        }

        return $lineItems;
    }

    public function getUnitRefundClass(): string
    {
        return OrderItemRefund::class;
    }

    private function convertUnitRefundToLineItem(OrderItemRefund $unitRefund): LineItemInterface
    {
        /** @var OrderItemInterface|null $orderItem */
        $orderItem = $this->orderItemRepository->find($unitRefund->id());
        Assert::notNull($orderItem);
        Assert::lessThanEq($unitRefund->total(), $orderItem->getTotal());

        $grossValue = $unitRefund->total();
        $taxAmount = (int) ($grossValue * $orderItem->getTaxTotal() / $orderItem->getTotal());
        $netValue = $grossValue - $taxAmount;

        /** @var string|null $productName */
        $productName = $orderItem->getProductName();
        Assert::notNull($productName);

        return new LineItem(
            $productName,
            1,
            $netValue,
            $grossValue,
            $netValue,
            $grossValue,
            $taxAmount,
            $this->taxRateProvider->provide($orderItem)
        );
    }

    /**
     * @param LineItemInterface[] $lineItems
     *
     * @return LineItemInterface[]
     */
    private function addLineItem(LineItemInterface $newLineItem, array $lineItems): array
    {
        foreach ($lineItems as $lineItem) {
            if ($lineItem->compare($newLineItem)) {
                $lineItem->merge($newLineItem);

                return $lineItems;
            }
        }

        $lineItems[] = $newLineItem;

        return $lineItems;
    }
}
