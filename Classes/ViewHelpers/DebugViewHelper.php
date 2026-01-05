<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class DebugViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function render(): string
    {
        $request = $this->renderingContext->getRequest();
        $frontendUser = $request?->getAttribute('frontend.user');
        
        if ($frontendUser === null) {
            return '<div style="color:red;">No frontend user in request</div>';
        }
        
        $data = $frontendUser->getKey('ses', 'tuning_tool_shop_cart');
        
        return '<div style="color:green;">Frontend user OK, Session data: ' . json_encode($data) . '</div>';
    }
}
