<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

class TagRepository extends Repository
{
    protected $defaultOrderings = [
        'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
    ];
}
