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
use Sylius\RefundPlugin\Converter\RefundUnitsConverterInterface;
use Sylius\RefundPlugin\Converter\RequestToRefundUnitsConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class RequestToOrderItemRefundConverter implements RequestToRefundUnitsConverterInterface
{
    public function __construct(private RefundUnitsConverterInterface $refundUnitsConverter)
    {
    }

    /**
     * @return OrderItemRefund[]
     */
    public function convert(Request $request): array
    {
        return $this->refundUnitsConverter->convert(
            $request->request->all()['sylius_refund_items'] ?? [],
            OrderItemRefund::class
        );
    }
}
