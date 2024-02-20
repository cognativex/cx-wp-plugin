<?php

class charts
{
    public static function design()
    {

        ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="container">
            <div class="text-center">
                <h1 class="mt-5"> CognativeX Analytics Dashboard</h1>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-md-3">
                    <div class="analytics-section">
                        <h5>Page Views </h5>
                        <h5 id="pageviews" class="analytics-data"></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="analytics-section">
                        <h5>Total Clicks </h5>
                        <h5 id="total_clicks" class=analytics-data></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="analytics-section">
                        <h5>Impressions</h5>
                        <h5 id="impressions" class=analytics-data></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="analytics-section">
                        <h5>CTR</h5>
                        <h5 id="CTR" class=analytics-data></h5>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="analytics-section">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="analytics-section">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .analytics-container {
                display: flex;
                justify-content: space-around;
                margin-top: 20px;
            }

            .analytics-section {
                width: 100%;
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .analytics-section h5 {
                margin-top: 0;
            }

            .analytics-data {
                color: #8b3091;
            }
        </style>
        <script>
            function formatNumbers(number) {
                if (number > 1000) {
                    number = ((number / 1000).toFixed(2)).toLocaleString(undefined, {maximumFractionDigits: 3}) + 'K';
                } else {
                    number = number.toLocaleString();
                }
                return number;
            }</script>
        <?php
    }

    public static function getClicksWithDate($domain)
    {
        ?>
        <script>
            var domain = '<?php echo $domain; ?>';
            //         var domain='almayadeen.net';
            // Fetch data from the API
            fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp-clicks_date_analysis?domain=' + domain)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(jsonResponse => {
                    // Process the JSON data
                    const dateArray = [];
                    const clicksArray = [];

                    jsonResponse.forEach(item => {
                        dateArray.push(item.date);
                        clicksArray.push(item.clicks);
                    });

                    // Update the chart data
                    const ctx1 = document.getElementById('myChart1').getContext('2d');
                    const myChart = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: dateArray,
                            datasets: [{
                                label: 'Clicks',
                                data: clicksArray,
                                backgroundColor: '#8b3091',
                                borderColor: '#8b3091',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        </script>
        <?php
    }

    // var pageViewsElement = document.getElementById("page_views");
    // fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp-get_page_views?domain=' + domain)
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //         }
    //         return response.json();
    //     })
    //     .then(jsonResponse => {
    //         // Accessing the single value from the JSON response
    //         var pageViews = jsonResponse;
    //
    //         // Now you can use the pageViews variable to do whatever you need with the value
    //         pageViewsElement.textContent = formatNumbers(pageViews);
    //
    //     })
    //     .catch(error => {
    //         console.error('Error fetching data:', error);
    //     });
    public static function getPageViewsWithDate($domain)
    {
        ?>
        <script>
            var domain = '<?php echo $domain; ?>';
            // Fetch data from the API
            fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp-page_views_date_analysis?domain=' + domain)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(jsonResponse => {
                    // Process the JSON data
                    const dateArray = [];
                    const pageViewArray = [];

                    jsonResponse.forEach(item => {
                        dateArray.push(item.date);
                        pageViewArray.push(item.pageViews);
                    });
                    // Update the chart data
                    const ctx2 = document.getElementById('myChart2').getContext('2d');
                    const myChart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: dateArray,
                            datasets: [{
                                label: 'Page Views',
                                data: pageViewArray,
                                backgroundColor: '#8b3091',
                                borderColor: '#8b3091',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });


        </script>
        <?php
    }

    public static function getAnalysisResults($domain)
    {
        ?>
        <script>
            var domain = '<?php echo $domain; ?>';
            var pageViewsElement = document.getElementById("pageviews");
            var impressionsElement = document.getElementById("impressions");
            var totalClicksElement = document.getElementById("total_clicks");
            var CTRElement = document.getElementById("CTR");

            // Fetch data from the API
            fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp_CX_analysis?domain='
                + domain + "&date1=2023-07-01&date2=2023-07-01")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(jsonResponse => {
                    pageViewsElement.textContent = formatNumbers(jsonResponse.pageviews);
                    impressionsElement.textContent = formatNumbers(jsonResponse.impressions);
                    totalClicksElement.textContent = formatNumbers(jsonResponse.clicks);
                    CTRElement.textContent = (formatNumbers(jsonResponse.CTR)) + " %";
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });


        </script>
        <?php


    }
}

?>