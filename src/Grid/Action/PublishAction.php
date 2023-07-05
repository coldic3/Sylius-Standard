<?php

declare(strict_types=1);

namespace App\Grid\Action;

use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\ActionInterface;

final class PublishAction
{
    public static function create(array $options = []): ActionInterface
    {
        $action = Action::create('publish', 'publish');
        $action->setLabel('Publish');
        $action->setOptions($options);

        return $action;
    }
}
