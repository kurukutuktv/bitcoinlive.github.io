function fetchBitcoinPrice() {
    fetch('https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            const btcPrice = parseFloat(data.price).toFixed(2); // Formatting the price to 2 decimal places
            document.getElementById('btcPrice').innerText = `Current Bitcoin Price: $${btcPrice}`;
        })
        .catch(error => {
            console.error('Error fetching Bitcoin price:', error);
        });
}
