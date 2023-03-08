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

namespace App\Entity\Refund\Type;

use App\Entity\Refund\RefundType;
use Sylius\RefundPlugin\Model\RefundTypeInterface;

final class RefundEnumType extends \Sylius\RefundPlugin\Entity\Type\RefundEnumType
{
    protected function createType($value): RefundTypeInterface
    {
        return new RefundType($value);
    }
}
