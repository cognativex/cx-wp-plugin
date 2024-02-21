<?php

class charts
{
    public static function design($domain)
    {

        ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="container">
            <div class="text-center d-flex justify-content-between align-items-center mt-5">
                <div>
                    <h2 class="mt mb-0">CognativeX Analytics Dashboard</h2>
                </div>
                <div>
                    <select id="DateSelect" class="custom-select" style="width: auto;">
                        <option value="1day">Yesterday</option>
                        <option value="7days">7 Days</option>
                        <option value="14days">14 Days</option>
                        <option value="30days">30 Days</option>
                    </select>
                </div>
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

            .text-center {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            /* Custom styling for select element */
            .custom-select {
                display: inline-block;
                vertical-align: middle;
                padding: 8px 12px;
                font-size: 14px;
                border-radius: 5px;
                background-color: #f0f0f0;
                border: 1px solid #ccc;
                outline: none;
                transition: border-color 0.2s ease-in-out;
            }

            .custom-select:hover,
            .custom-select:focus {
                border-color: #999;
            }
        </style>
        <script>
            var domain = '<?php echo $domain; ?>';

            //format numbers
            function formatNumbers(number) {
                if (number > 1000) {
                    number = ((number / 1000).toFixed(2)).toLocaleString(undefined, {maximumFractionDigits: 3}) + 'K';
                } else {
                    number = number.toLocaleString();
                }
                return number;
            }

            //parsing date to YYYY-MM-DD format function
            function getDate(date) {
                var yesterday = new Date();
                yesterday.setDate(yesterday.getDate() - date);
                var formattedDate = yesterday.toISOString().split('T')[0];
                return formattedDate;
            }

            ///results api by date
            function getAnalysisResults(domain, date1, date2) {
                var pageViewsElement = document.getElementById("pageviews");
                var impressionsElement = document.getElementById("impressions");
                var totalClicksElement = document.getElementById("total_clicks");
                var CTRElement = document.getElementById("CTR");

                // Fetch data from the API
                fetch('https://us-central1-cognativex-dev.cloudfunctions.net/wp_CX_analysis?domain='
                    + domain + "&date1=" + date1 + "&date2=" + date2)
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


            }

            //default select->yesterday
            // Trigger the change event manually when the page is loaded to handle the default selected option
            document.addEventListener("DOMContentLoaded", function () {
                var defaultSelectedValue = document.getElementById("DateSelect").value;
                getAnalysisResults(domain, getDate(1), getDate(1));
            });
            //the analysis results will be changed based on the selected date
            document.getElementById("DateSelect").addEventListener("change", function () {
                var selectedValue = this.value;
                switch (selectedValue) {
                    case "1day":
                        getAnalysisResults(domain, getDate(1), getDate(1));
                        break;
                    case "7days":
                        getAnalysisResults(domain, getDate(1), getDate(7));
                        break;
                    case "14days":
                        getAnalysisResults(domain, getDate(1), getDate(14));
                        break;
                    case "30days":
                        getAnalysisResults(domain, getDate(1), getDate(30));
                        break;
                }

            });
        </script>
        <?php
    }

    public static function getClicksWithDate()
    {
        ?>
        <script>
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

    public static function getPageViewsWithDate()
    {
        ?>
        <script>
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


}

?>