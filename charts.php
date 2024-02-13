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
                        <h5 id="page_views" class="analytics-data"></h5>
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
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="analytics-section">
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="analytics-section">
                        <canvas id="myChart4"></canvas>
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
                color: rgba(75, 192, 192, 1);
            }
        </style>

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
                    const daysArray = [];
                    const clicksArray = [];

                    jsonResponse.forEach(item => {
                        daysArray.push(item.day);
                        clicksArray.push(item.clicks);
                    });

                    // Update the chart data
                    const ctx1 = document.getElementById('myChart1').getContext('2d');
                    const myChart = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: daysArray,
                            datasets: [{
                                label: 'Clicks',
                                data: clicksArray,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
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

    public static function getPageViews($domain)
    {
        ?>
        <script>
            var pageViewsElement = document.getElementById("page_views");
            fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp-get_page_views?domain=' + domain)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(jsonResponse => {
                    // Accessing the single value from the JSON response
                    var pageViews = jsonResponse;

                    // Now you can use the pageViews variable to do whatever you need with the value
                    pageViewsElement.textContent = pageViews;

                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        </script>
        <?php
    }

    public static function getTotalClicks($domain)
    {
        ?>
        <script>
            var totalClicksElement = document.getElementById("total_clicks");
            fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp-total_clicks?domain=' + domain)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(jsonResponse => {
                    // Accessing the single value from the JSON response
                    var totalClicks = jsonResponse;

                    // Now you can use the totalClicks variable to do whatever you need with the value
                    totalClicksElement.textContent = totalClicks;

                    // Create a custom event
                    var event = new Event('clicksElementUpdated');

                    // Dispatch the custom event
                    totalClicksElement.dispatchEvent(event);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        </script>
        <?php
    }

    public static function getImpressions($domain)
    {
        ?>
        <script>
            var impressionsElement = document.getElementById("impressions");
            fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp-impressions?domain=' + domain)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(jsonResponse => {
                    // Accessing the single value from the JSON response
                    var impressions = jsonResponse;

                    // Now you can use the impressions variable to do whatever you need with the value
                    impressionsElement.textContent = impressions;

                    // Create a custom event
                    var event = new Event('impressionsElementUpdated');

                    // Dispatch the custom event
                    impressionsElement.dispatchEvent(event);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        </script>
        <?php
    }

    public static function getCTR()
    {
        ?>
        <script>
            var totalClicksElement = document.getElementById("total_clicks");
            var impressionsElement = document.getElementById("impressions");

            // Flag to track whether both events have been dispatched
            var eventsDispatched = {
                totalClicksUpdated: false,
                impressionsUpdated: false
            };

            // Event listener for total clicks element
            totalClicksElement.addEventListener('clicksElementUpdated', function () {
                eventsDispatched.totalClicksUpdated = true;
                checkEventsDispatched();
            });

            // Event listener for impressions element
            impressionsElement.addEventListener('impressionsElementUpdated', function () {
                eventsDispatched.impressionsUpdated = true;
                checkEventsDispatched();
            });

            // Function to check if both events have been dispatched
            function checkEventsDispatched() {
                if (eventsDispatched.totalClicksUpdated && eventsDispatched.impressionsUpdated) {
                    var clicks = totalClicksElement.textContent;
                    var impressions = impressionsElement.textContent;
                    if (impressions == 0) {
                        document.getElementById("CTR").textContent = 0
                    } else {
                        var CTR = ((clicks / impressions) * 100).toFixed(2)
                        document.getElementById("CTR").textContent = CTR + " %";
                    }


                }
            }
        </script>
        <?php
    }

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
                    const daysArray = [];
                    const pageViewArray = [];

                    jsonResponse.forEach(item => {
                        daysArray.push(item.day);
                        pageViewArray.push(item.pageViews);
                    });


                    // Update the chart data
                    const ctx2 = document.getElementById('myChart2').getContext('2d');
                    const myChart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: daysArray,
                            datasets: [{
                                label: 'Page Views',
                                data: pageViewArray,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
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


}

?>