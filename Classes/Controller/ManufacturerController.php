<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Controller;

use Hamstahstudio\TuningToolShop\Domain\Repository\ManufacturerRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ManufacturerController extends ActionController
{
    public function __construct(
        protected readonly ManufacturerRepository $manufacturerRepository
    ) {}

    public function listAction(): ResponseInterface
    {
        $manufacturers = $this->manufacturerRepository->findAll();
        $this->view->assign('manufacturers', $manufacturers);
        return $this->htmlResponse();
    }
}
