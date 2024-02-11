function viewTradingView() {
    const intervalDropdown = document.getElementById('intervalDropdown');
    const themeSwitch = document.getElementById('themeSwitch');

    // Function to create a new TradingView widget based on dropdown and switch values
    function createNewChart() {
        new TradingView.widget({
            "width": 800,
            "height": 500,
            "symbol": "BINANCE:BTCUSDT",
            "interval": intervalDropdown.value,
            "timezone": "Etc/UTC",
            "theme": themeSwitch.checked ? "dark" : "light",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "hide_top_toolbar": true,
            "container_id": "tradingview_btcusdt"
        });
    }

    // Initialize chart with default values
    createNewChart();

    // Event listeners to detect dropdown and switch changes and update the chart accordingly
    intervalDropdown.addEventListener('change', createNewChart);
    themeSwitch.addEventListener('change', createNewChart);
}
