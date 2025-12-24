<?php

declare(strict_types=1);

namespace Hamstahstudio\TuningToolShop\Api;

use Hamstahstudio\TuningToolShop\Domain\Repository\OrderRepository;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Psr\Log\LoggerInterface;

/**
 * @Api\Endpoint()
 */
class Order extends AbstractApi
{
    public function __construct(
        readonly private OrderRepository $orderRepository,
        readonly private LoggerInterface $logger
    ) {
    }

    /**
     * ## Alle Bestellungen abrufen
     *
     * Ruft alle Bestellungen aus der Datenbank ab.
     *
     * ### Beispiel
     *
     * ```
     * GET /api/order/all
     * ```
     *
     * ### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [
     *     {
     *       "uid": 1,
     *       "orderNumber": "ORD-2024-001",
     *       "customerEmail": "customer@example.com",
     *       "customerName": "Max Mustermann",
     *       "total": 199.99,
     *       "status": 2,
     *       "paymentStatus": 1,
     *       "createdAt": "2024-01-15T10:30:00+01:00"
     *     }
     *   ],
     *   "count": 1
     * }
     * ```
     *
     * @Api\Access("public")
     * @return array
     */
     public function allAction(): array
     {
        try {
            $orders = $this->orderRepository->findAll();
            return [
                'success' => true,
                'data' => $orders,
                'count' => $orders->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching orders', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching orders',
            ];
        }
     }

     /**
     * ## Alias für alle Bestellungen
     *
     * Alias für allAction()
     *
     * @Api\Route("/order/all")
     * @Api\Access("public")
     * @return array
     */
     public function getAllAction(): array
     {
        return $this->allAction();
     }

    /**
     * ## Einzelne Bestellung abrufen
     *
     * Ruft eine einzelne Bestellung nach ihrer UID ab.
     *
     * ### Beispiel
     *
     * ```
     * GET /api/order/1
     * ```
     *
     * ### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": {
     *     "uid": 1,
     *     "orderNumber": "ORD-2024-001",
     *     "customerEmail": "customer@example.com",
     *     "total": 199.99,
     *     "status": 2
     *   }
     * }
     * ```
     *
     * @Api\Access("public")
     * @return array
     */
    public function getIndexAction(): array
    {
        try {
            // Get UID from request arguments (nnrestapi passes it as uid parameter)
            $args = $this->request->getArguments();
            $uid = (int)($args['uid'] ?? 0);

            if ($uid === 0) {
                return [
                    'success' => false,
                    'message' => 'Order UID required',
                ];
            }

            $order = $this->orderRepository->findByUidIgnoreStorage($uid);

            if ($order === null) {
                return [
                    'success' => false,
                    'message' => 'Order not found',
                ];
            }

            return [
                'success' => true,
                'data' => $order,
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching order', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching order',
            ];
        }
    }

    /**
     * ## Bestellung nach Bestellnummer
     *
     * Sucht eine Bestellung nach ihrer Bestellnummer.
     *
     * ### Parameter
     *
     * - **number** (erforderlich): Die Bestellnummer (z.B. ORD-2024-001)
     *
     * ### Beispiele
     *
     * #### Bestellung ORD-2024-001 abrufen
     *
     * ```
     * GET /api/order/number?number=ORD-2024-001
     * ```
     *
     * #### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": {
     *     "uid": 1,
     *     "orderNumber": "ORD-2024-001",
     *     "customerEmail": "customer@example.com",
     *     "total": 199.99,
     *     "status": 2
     *   }
     * }
     * ```
     *
     * @Api\Route("/order/number")
     * @Api\Access("public")
     * @return array
     */
    public function getNumberAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $orderNumber = $args['number'] ?? '';

            if (empty($orderNumber)) {
                return [
                    'success' => false,
                    'message' => 'Order number required',
                ];
            }

            $order = $this->orderRepository->findByOrderNumber($orderNumber);

            if ($order === null) {
                return [
                    'success' => false,
                    'message' => 'Order not found',
                ];
            }

            return [
                'success' => true,
                'data' => $order,
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching order by number', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching order',
            ];
        }
    }

    /**
     * ## Bestellungen nach Kundenemails
     *
     * Ruft alle Bestellungen eines Kunden anhand seiner E-Mail-Adresse ab.
     *
     * ### Parameter
     *
     * - **email** (erforderlich): Die E-Mail-Adresse des Kunden
     *
     * ### Beispiele
     *
     * #### Bestellungen von customer@example.com
     *
     * ```
     * GET /api/order/email?email=customer@example.com
     * ```
     *
     * #### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [
     *     {
     *       "uid": 1,
     *       "orderNumber": "ORD-2024-001",
     *       "customerEmail": "customer@example.com",
     *       "total": 199.99,
     *       "status": 2
     *     }
     *   ],
     *   "count": 3
     * }
     * ```
     *
     * @Api\Route("/order/email")
     * @Api\Access("public")
     * @return array
     */
    public function getEmailAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $email = $args['email'] ?? '';

            if (empty($email)) {
                return [
                    'success' => false,
                    'message' => 'Email required',
                ];
            }

            $orders = $this->orderRepository->findByCustomerEmail($email);

            return [
                'success' => true,
                'data' => $orders,
                'count' => $orders->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching orders by email', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching orders',
            ];
        }
    }

    /**
     * ## Bestellungen nach Status filtern
     *
     * Ruft alle Bestellungen mit einem bestimmten Status ab.
     *
     * ### Parameter
     *
     * - **status** (erforderlich): Der Status der Bestellung
     *
     * ### Status-Codes
     *
     * | Code | Beschreibung |
     * |------|------------|
     * | 0 | Neu |
     * | 1 | In Bearbeitung |
     * | 2 | Bestätigt |
     * | 3 | Versendet |
     * | 4 | Abgeschlossen |
     * | 5 | Storniert |
     *
     * ### Beispiele
     *
     * #### Alle bestätigten Bestellungen
     *
     * ```
     * GET /api/order/status?status=2
     * ```
     *
     * #### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [
     *     {
     *       "uid": 1,
     *       "orderNumber": "ORD-2024-001",
     *       "status": 2,
     *       "total": 199.99
     *     }
     *   ],
     *   "count": 15
     * }
     * ```
     *
     * @Api\Route("/order/status")
     * @Api\Access("public")
     * @return array
     */
    public function getStatusAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $status = isset($args['status']) ? (int)$args['status'] : null;

            if ($status === null) {
                return [
                    'success' => false,
                    'message' => 'Status required',
                ];
            }

            $orders = $this->orderRepository->findByStatus($status);

            return [
                'success' => true,
                'data' => $orders,
                'count' => $orders->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching orders by status', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching orders',
            ];
        }
    }

    /**
     * ## Neueste Bestellungen
     *
     * Ruft die neuesten Bestellungen ab.
     *
     * ### Parameter
     *
     * - **limit** (optional): Anzahl der Bestellungen (default: 10)
     *
     * ### Beispiele
     *
     * #### 5 neueste Bestellungen
     *
     * ```
     * GET /api/order/recent?limit=5
     * ```
     *
     * #### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [...],
     *   "count": 5
     * }
     * ```
     *
     * @Api\Route("/order/recent")
     * @Api\Access("public")
     * @return array
     */
    public function getRecentAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $limit = (int)($args['limit'] ?? 10);

            $orders = $this->orderRepository->findRecent($limit);

            return [
                'success' => true,
                'data' => $orders,
                'count' => $orders->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching recent orders', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching recent orders',
            ];
        }
    }

    /**
     * ## Bestellungen eines Benutzers
     *
     * Ruft alle Bestellungen eines Frontend-Benutzers ab.
     *
     * ### Parameter
     *
     * - **user** (erforderlich): Die Benutzer-ID
     *
     * ### Beispiele
     *
     * #### Bestellungen von Benutzer 123
     *
     * ```
     * GET /api/order/user?user=123
     * ```
     *
     * #### Response
     *
     * ```json
     * {
     *   "success": true,
     *   "data": [
     *     {
     *       "uid": 1,
     *       "orderNumber": "ORD-2024-001",
     *       "customerEmail": "customer@example.com",
     *       "total": 199.99
     *     }
     *   ],
     *   "count": 2
     * }
     * ```
     *
     * @Api\Route("/order/user")
     * @Api\Access("public")
     * @return array
     */
    public function getUserAction(): array
    {
        try {
            $args = $this->request->getArguments();
            $userId = isset($args['user']) ? (int)$args['user'] : null;

            if ($userId === null) {
                return [
                    'success' => false,
                    'message' => 'User ID required',
                ];
            }

            $orders = $this->orderRepository->findByFrontendUserId($userId);

            return [
                'success' => true,
                'data' => $orders,
                'count' => $orders->count(),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Error fetching orders by user', ['exception' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error fetching orders',
            ];
        }
    }
}
