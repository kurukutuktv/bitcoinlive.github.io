<?php
// Binance API key and secret
$api_key = 'kDvQCeHlPWhOMWTT5C2I72n8L9t9mGWDOf7aBltV70K4Cz6aw2t9jDQhGreCp966';
$api_secret = 'OVFoVB9M9ecsvoq5GvE9tTkRi7WdXEJHL5ABFG4o15djyDIeiUZ4t8u96nlCstxU';

// Binance API endpoint
$base_url = 'https://api.binance.com';

// Function to make API requests
function callBinanceAPI($method, $url, $params = []) {
    global $api_key, $api_secret, $base_url;

    $query = http_build_query($params, '', '&');
    $timestamp = time() * 1000;
    $signature = hash_hmac('sha256', $query, $api_secret);

    $headers = [
        'X-MBX-APIKEY: ' . $api_key
    ];

    $ch = curl_init();
    $url = $base_url . $url . '?' . $query . '&timestamp=' . $timestamp . '&signature=' . $signature;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

// Function to get latest Bitcoin price
function getBitcoinPrice() {
    $ticker = callBinanceAPI('GET', '/api/v3/ticker/price', ['symbol' => 'BTCUSDT']);
    return $ticker['price'];
}

// Function to get user's current trading pairs
function getCurrentTradingPairs() {
    // Modify this according to your needs
    // You may need to call different endpoints based on your specific trading pairs
    $user_trading_pairs = callBinanceAPI('GET', '/api/v3/account');
    return $user_trading_pairs['balances'];
}

// Function to place a spot market buy order
function spotMarketBuy($symbol, $quantity) {
    $response = callBinanceAPI('POST', '/api/v3/order', [
        'symbol' => $symbol,
        'side' => 'BUY',
        'type' => 'MARKET',
        'quantity' => $quantity,
    ]);
    return $response;
}

// Function to place a spot market sell order
function spotMarketSell($symbol, $quantity) {
    $response = callBinanceAPI('POST', '/api/v3/order', [
        'symbol' => $symbol,
        'side' => 'SELL',
        'type' => 'MARKET',
        'quantity' => $quantity,
    ]);
    return $response;
}

// Example usage:
// Get Bitcoin price
$bitcoinPrice = getBitcoinPrice();
echo 'Latest Bitcoin Price: ' . $bitcoinPrice . ' USDT<br>';

// Get user's current trading pairs
$userTradingPairs = getCurrentTradingPairs();
echo 'Current Trading Pairs:<br>';
foreach ($userTradingPairs as $pair) {
    echo $pair['asset'] . ': ' . $pair['free'] . '<br>';
}

// Example: Place a spot market buy order for 1 BTC
//$buyOrder = spotMarketBuy('BTCUSDT', 1);
//print_r($buyOrder);

// Example: Place a spot market sell order for 0.5 BTC
//$sellOrder = spotMarketSell('BTCUSDT', 0.5);
//print_r($sellOrder);
?>