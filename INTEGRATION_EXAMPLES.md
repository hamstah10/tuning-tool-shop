# REST API - Integrations-Beispiele

Beispiele für die Integration der TuningToolShop REST API in verschiedene externe Systeme.

## bash/curl

### Alle Produkte abrufen

```bash
#!/bin/bash

API_URL="https://tfd.example.com/api"

# Alle Produkte abrufen
curl -X GET "$API_URL/product" \
  -H "Accept: application/json" | jq '.'

# Speichern in JSON-Datei
curl -X GET "$API_URL/product" \
  -H "Accept: application/json" \
  -o products.json

# Mit Timeout
curl -X GET "$API_URL/product" \
  --max-time 10 \
  -H "Accept: application/json"
```

### Produktsuche mit Fehlerbehandlung

```bash
#!/bin/bash

API_URL="https://tfd.example.com/api"
SEARCH_TERM="chiptuning"

RESPONSE=$(curl -s -X GET "$API_URL/product/search?term=$SEARCH_TERM" \
  -H "Accept: application/json")

SUCCESS=$(echo $RESPONSE | jq -r '.success')

if [ "$SUCCESS" = "true" ]; then
    COUNT=$(echo $RESPONSE | jq -r '.count')
    echo "Gefunden: $COUNT Produkte"
    echo $RESPONSE | jq '.data[] | {title: .title, price: .price, sku: .sku}'
else
    echo "Fehler: $(echo $RESPONSE | jq -r '.message')"
fi
```

### Bestellungen synchronisieren

```bash
#!/bin/bash

API_URL="https://tfd.example.com/api"
WEBHOOK_URL="https://external-system.com/webhook/orders"
LOG_FILE="/var/log/order-sync.log"

# Neueste Bestellungen abrufen
ORDERS=$(curl -s -X GET "$API_URL/order/recent?limit=50" \
  -H "Accept: application/json")

# Zu externem System senden
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d "$ORDERS" \
  >> $LOG_FILE 2>&1

echo "$(date) - Bestellungen synchronisiert" >> $LOG_FILE
```

---

## PHP

### Produkte laden

```php
<?php
$apiUrl = 'https://tfd.example.com/api';

// Alle Produkte
$response = file_get_contents($apiUrl . '/product');
$data = json_decode($response, true);

if ($data['success']) {
    foreach ($data['data'] as $product) {
        echo $product['title'] . ' - ' . $product['price'] . '€<br>';
    }
} else {
    echo 'Fehler: ' . $data['message'];
}
```

### Mit cURL und Fehlerbehandlung

```php
<?php
class TuningShopApiClient {
    private $baseUrl;
    private $timeout = 10;

    public function __construct($baseUrl) {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function get($endpoint, $params = []) {
        $url = $this->baseUrl . '/api' . $endpoint;
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("HTTP $httpCode: $response");
        }

        return json_decode($response, true);
    }

    public function getProducts() {
        return $this->get('/product');
    }

    public function getProduct($uid) {
        return $this->get('/product/' . $uid);
    }

    public function searchProducts($term) {
        return $this->get('/product/search', ['term' => $term]);
    }

    public function getOrders() {
        return $this->get('/order');
    }

    public function getOrder($uid) {
        return $this->get('/order/' . $uid);
    }

    public function getOrdersByEmail($email) {
        return $this->get('/order/email', ['email' => $email]);
    }

    public function getOrdersByStatus($status) {
        return $this->get('/order/status', ['status' => $status]);
    }
}

// Verwendung
$client = new TuningShopApiClient('https://tfd.example.com');

try {
    $products = $client->getProducts();
    $orders = $client->getOrdersByStatus(2); // Bestätigt
    
    echo "Produkte: " . count($products['data']) . "\n";
    echo "Bestellungen: " . count($orders['data']) . "\n";
} catch (Exception $e) {
    echo "Fehler: " . $e->getMessage();
}
```

---

## Python

### Einfaches Abrufen

```python
import requests
import json

api_url = 'https://tfd.example.com/api'

# Alle Produkte
response = requests.get(f'{api_url}/product')
data = response.json()

if data['success']:
    for product in data['data']:
        print(f"{product['title']} - {product['price']}€")
else:
    print(f"Fehler: {data['message']}")
```

### Mit Fehlerbehandlung und Logging

```python
import requests
import logging
from typing import Optional, Dict, List

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

class TuningShopAPI:
    def __init__(self, base_url: str, timeout: int = 10):
        self.base_url = base_url.rstrip('/')
        self.api_url = f"{self.base_url}/api"
        self.timeout = timeout
        self.session = requests.Session()

    def _get(self, endpoint: str, params: Optional[Dict] = None) -> Dict:
        """HTTP GET Request mit Fehlerbehandlung"""
        url = f"{self.api_url}{endpoint}"
        try:
            response = self.session.get(
                url,
                params=params,
                timeout=self.timeout,
                headers={'Accept': 'application/json'}
            )
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            logger.error(f"API Fehler: {e}")
            return {'success': False, 'message': str(e)}

    def get_products(self) -> List[Dict]:
        """Alle Produkte abrufen"""
        response = self._get('/product')
        return response.get('data', []) if response.get('success') else []

    def get_product(self, uid: int) -> Optional[Dict]:
        """Einzelnes Produkt abrufen"""
        response = self._get(f'/product/{uid}')
        return response.get('data') if response.get('success') else None

    def search_products(self, term: str) -> List[Dict]:
        """Produkte suchen"""
        response = self._get('/product/search', {'term': term})
        return response.get('data', []) if response.get('success') else []

    def get_orders(self) -> List[Dict]:
        """Alle Bestellungen abrufen"""
        response = self._get('/order')
        return response.get('data', []) if response.get('success') else []

    def get_order(self, uid: int) -> Optional[Dict]:
        """Einzelne Bestellung abrufen"""
        response = self._get(f'/order/{uid}')
        return response.get('data') if response.get('success') else None

    def get_orders_by_email(self, email: str) -> List[Dict]:
        """Bestellungen nach Email abrufen"""
        response = self._get('/order/email', {'email': email})
        return response.get('data', []) if response.get('success') else []

    def get_orders_by_status(self, status: int) -> List[Dict]:
        """Bestellungen nach Status abrufen"""
        response = self._get('/order/status', {'status': status})
        return response.get('data', []) if response.get('success') else []

# Verwendung
if __name__ == '__main__':
    api = TuningShopAPI('https://tfd.example.com')
    
    # Produkte laden
    products = api.get_products()
    print(f"Gefundene Produkte: {len(products)}")
    for product in products:
        print(f"  - {product['title']} ({product['sku']}) - {product['price']}€")
    
    # Nach Produkten suchen
    search_results = api.search_products('chiptuning')
    print(f"\nSuchergebnisse für 'chiptuning': {len(search_results)}")
    
    # Bestellungen abrufen
    orders = api.get_orders_by_status(2)  # Bestätigt
    print(f"\nBestätigte Bestellungen: {len(orders)}")
    
    # Kundenbestellungen
    customer_orders = api.get_orders_by_email('customer@example.com')
    print(f"Bestellungen des Kunden: {len(customer_orders)}")
```

### Mit Pagination

```python
import requests
from typing import List, Dict

class TuningShopAPIPaginated:
    def __init__(self, base_url: str):
        self.api_url = f"{base_url.rstrip('/')}/api"
        self.page_size = 50

    def get_all_products(self) -> List[Dict]:
        """Alle Produkte mit Pagination abrufen"""
        all_products = []
        
        response = requests.get(f'{self.api_url}/product')
        data = response.json()
        
        if data['success']:
            all_products.extend(data['data'])
            
            # Weitere Seiten laden (wenn implementiert)
            while len(data.get('data', [])) == self.page_size:
                # Logik für nächste Seite...
                pass
        
        return all_products

api = TuningShopAPIPaginated('https://tfd.example.com')
all_products = api.get_all_products()
print(f"Geladen: {len(all_products)} Produkte")
```

---

## JavaScript/Node.js

### Mit fetch

```javascript
const API_URL = 'https://tfd.example.com/api';

// Alle Produkte abrufen
fetch(`${API_URL}/product`)
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      console.log('Produkte:', data.data);
    } else {
      console.error('Fehler:', data.message);
    }
  });

// Produktsuche
async function searchProducts(term) {
  const response = await fetch(
    `${API_URL}/product/search?term=${encodeURIComponent(term)}`
  );
  const data = await response.json();
  return data.success ? data.data : [];
}

// Bestellungen laden
async function loadCustomerOrders(email) {
  const response = await fetch(
    `${API_URL}/order/email?email=${encodeURIComponent(email)}`
  );
  return await response.json();
}
```

### Mit axios

```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'https://tfd.example.com/api',
  headers: { 'Accept': 'application/json' }
});

// Alle Produkte
api.get('/product').then(res => {
  console.log(res.data.data);
});

// Mit Fehlerbehandlung
api.get('/product/search', {
  params: { term: 'chiptuning' }
}).then(res => {
  console.log('Gefunden:', res.data.count);
}).catch(err => {
  console.error('Fehler:', err.message);
});
```

### Mit Express.js Proxy

```javascript
const express = require('express');
const axios = require('axios');
const app = express();

const API_URL = 'https://tfd.example.com/api';

// Proxy für Produktsuche
app.get('/search', async (req, res) => {
  try {
    const { term } = req.query;
    const response = await axios.get(`${API_URL}/product/search`, {
      params: { term }
    });
    res.json(response.data);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Proxy für Kundenbestellungen
app.get('/customer-orders/:email', async (req, res) => {
  try {
    const { email } = req.params;
    const response = await axios.get(`${API_URL}/order/email`, {
      params: { email }
    });
    res.json(response.data);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

app.listen(3000);
```

---

## Sync-Skripte

### Cron-Job für tägliche Synchronisation

**cron-sync-orders.sh**
```bash
#!/bin/bash

API_URL="https://tfd.example.com/api"
DB_HOST="localhost"
DB_NAME="external_db"
DB_USER="sync_user"
TIMESTAMP=$(date +%Y-%m-%d_%H-%M-%S)
LOG="/var/log/tuning-shop-sync-$TIMESTAMP.log"

echo "START: $(date)" >> $LOG

# Neueste Bestellungen abrufen
ORDERS=$(curl -s -X GET "$API_URL/order/recent?limit=100" \
  -H "Accept: application/json")

# In externe Datenbank importieren
echo "$ORDERS" | python3 - <<EOF
import sys, json, mysql.connector

config = {
    'host': '$DB_HOST',
    'user': '$DB_USER',
    'password': 'PASSWORD',
    'database': '$DB_NAME'
}

data = json.load(sys.stdin)
conn = mysql.connector.connect(**config)
cursor = conn.cursor()

for order in data.get('data', []):
    query = """
        INSERT INTO orders (uid, order_number, customer_email, total, status)
        VALUES (%s, %s, %s, %s, %s)
        ON DUPLICATE KEY UPDATE
        status = VALUES(status), total = VALUES(total)
    """
    cursor.execute(query, (
        order['uid'],
        order['orderNumber'],
        order['customerEmail'],
        order['total'],
        order['status']
    ))

conn.commit()
cursor.close()
conn.close()
print(f"Synchronized {len(data.get('data', []))} orders")
EOF

echo "END: $(date)" >> $LOG
```

Füge in crontab ein:
```
0 2 * * * /usr/local/bin/cron-sync-orders.sh
```

---

## Error Handling Best Practices

```python
import requests
from requests.adapters import HTTPAdapter
from urllib3.util.retry import Retry

def requests_with_retries():
    """Session mit automatischen Retries"""
    session = requests.Session()
    retry = Retry(
        total=3,
        backoff_factor=0.5,
        status_forcelist=[500, 502, 503, 504]
    )
    adapter = HTTPAdapter(max_retries=retry)
    session.mount('http://', adapter)
    session.mount('https://', adapter)
    return session

# Verwendung
session = requests_with_retries()
response = session.get('https://tfd.example.com/api/product')
```

---

## Sicherheit

### Mit API-Key (wenn implementiert)

```bash
curl -X GET "https://tfd.example.com/api/product" \
  -H "X-API-Key: your-api-key-here"
```

```python
import requests

headers = {
    'X-API-Key': 'your-api-key-here',
    'Accept': 'application/json'
}
response = requests.get(
    'https://tfd.example.com/api/product',
    headers=headers
)
```

### HTTPS & SSL Verification

```python
# SSL verification enabled (standard)
response = requests.get('https://tfd.example.com/api/product')

# Mit Custom CA Certificate
response = requests.get(
    'https://tfd.example.com/api/product',
    verify='/path/to/ca-bundle.crt'
)
```

