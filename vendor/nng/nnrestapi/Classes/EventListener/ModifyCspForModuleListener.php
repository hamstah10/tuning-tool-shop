<?php

declare(strict_types=1);

namespace Nng\Nnrestapi\EventListener;

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\PolicyMutatedEvent;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;

/**
 * Event listener to modify Content Security Policy (CSP) for the nnrestapi backend module.
 * 
 * The nnrestapi backend module uses a reactive JavaScript framework that requires 
 * 'unsafe-eval' in the CSP script-src directive. This event listener adds 'unsafe-eval' 
 * only when the nnrestapi backend module is requested, ensuring that the global TYPO3 
 * backend CSP remains strict and unaffected for all other modules.
 * 
 */
final class ModifyCspForModuleListener
{
    public function __invoke(PolicyMutatedEvent $event): void
    {
        // Only apply to backend
        if ($event->scope->type->isFrontend()) {
            return;
        }

        // Check if this is our module by inspecting the request
        $request = $event->request;
        if ($request === null) {
            return;
        }

        // Get the route from the request
        $route = $request->getAttribute('route');
        if ($route === null) {
            return;
        }

        // Check if this is our module (route identifier starts with 'nnrestapi')
        $routeIdentifier = $route->getOption('_identifier') ?? '';
        if (!str_starts_with($routeIdentifier, 'nnrestapi')) {
            return;
        }

        // Add unsafe-eval only for our module
        $event->getCurrentPolicy()->extend(
            Directive::ScriptSrc,
            SourceKeyword::unsafeEval,
        );
    }
}
