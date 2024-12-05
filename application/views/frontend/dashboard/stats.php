<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Summary</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Activated Customers</th>
                                <td><?php echo $customer_stats['activated']; ?></td>
                            </tr>
                            <tr>
                                <th>New Customers</th>
                                <td><?php echo $customer_stats['new']; ?></td>
                            </tr>
                            <tr>
                                <th>Disabled Customers</th>
                                <td><?php echo $customer_stats['disabled']; ?></td>
                            </tr>
                            <tr>
                                <th>Expired Customers</th>
                                <td><?php echo $customer_stats['expired']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Content Summary</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Series</th>
                                <td><?php echo $vod_stats['series']; ?></td>
                            </tr>
                            <tr>
                                <th>Movies</th>
                                <td><?php echo $vod_stats['movies']; ?></td>
                            </tr>
                            <tr>
                                <th>TV Shows</th>
                                <td><?php echo $vod_stats['tv_show']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Statistics</h3>
                    </div>
                    <div class="box-body">
                        <div id="customer_distribution" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Content Statistics</h3>
                    </div>
                    <div class="box-body">
                        <div id="vod_distribution" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Customer Stats -->

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Additions</h3>
                    </div>
                    <div class="box-body">
                        <div id="customer_chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Movie Additions</h3>
                    </div>
                    <div class="box-body">
                        <div id="movie_chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Series Additions</h3>
                    </div>
                    <div class="box-body">
                        <div id="series_chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

function generateRandomData() {
    var data = [];
    var endDate = new Date();
    var startDate = new Date();
    startDate.setFullYear(endDate.getFullYear() - 2); // 2 years of data
    
    // Generate daily data points
    for (var date = new Date(startDate); date <= endDate; date.setDate(date.getDate() + 10)) {
        data.push([
            date.getTime(),
            Math.round(Math.random() * 100 + 50) // Random value between 50-150
        ]);
    }
    
    return data;
}

// Use either version
var data = generateRandomData();  // This will create more realistic-looking data

// Rest of your chart configuration remains the same...

<?php 
echo $customer_pie_chart;
echo $vod_bar_chart;
?>


// Convert PHP data to JavaScript array
const customerData = <?php echo json_encode($customer_chart_data); ?>;

// Transform data into format required by Highcharts
// Accumulate the counts to show total growth
let totalCustomers = 0;
const cData = customerData.map(item => {
    totalCustomers += parseInt(item.count);
    return [
        new Date(item.date).getTime(),
        totalCustomers
    ];
});

// Create the chart
Highcharts.stockChart('customer_chart', {
    rangeSelector: {
        buttons: [{
            type: 'day',
            count: 7,
            text: '1w'
        }, {
            type: 'month',
            count: 1,
            text: '1m'
        }, {
            type: 'month',
            count: 3,
            text: '3m'
        }, {
            type: 'month',
            count: 6,
            text: '6m'
        }, {
            type: 'year',
            count: 1,
            text: '1y'
        }, {
            type: 'all',
            text: 'All'
        }],
        selected: 1
    },
    title: {
        text: 'Total Customer Growth'
    },
    yAxis: {
        title: {
            text: 'Total Number of Customers'
        },
        min: 0
    },
    series: [{
        name: 'Total Customers',
        data: cData,
        tooltip: {
            valueDecimals: 0
        }
    }],
    tooltip: {
        formatter: function() {
            return Highcharts.dateFormat('%Y-%m-%d', this.x) + '<br/>' +
                   '<b>Total Customers: </b>' + Highcharts.numberFormat(this.y, 0);
        }
    }
});


// Convert PHP data to JavaScript array
const movieData = <?php echo json_encode($movie_chart_data); ?>;

// Transform data into format required by Highcharts
// Accumulate the counts to show total growth
let totalMovies = 0;
const mData = movieData.map(item => {
    totalMovies += parseInt(item.count);
    return [
        new Date(item.date).getTime(),
        totalMovies
    ];
});

Highcharts.stockChart('movie_chart', {
    rangeSelector: {
        buttons: [{
            type: 'day',
            count: 7,
            text: '1w'
        }, {
            type: 'month',
            count: 1,
            text: '1m'
        }, {
            type: 'month',
            count: 3,
            text: '3m'
        }, {
            type: 'month',
            count: 6,
            text: '6m'
        }, {
            type: 'year',
            count: 1,
            text: '1y'
        }, {
            type: 'all',
            text: 'All'
        }],
        selected: 1
    },
    title: {
        text: 'Total Movie Growth'
    },
    yAxis: {
        title: {
            text: 'Total Number of Movies'
        },
        min: 0
    },
    series: [{
        name: 'Total Movies',
        data: mData,
        tooltip: {
            valueDecimals: 0
        }
    }],
    tooltip: {
        formatter: function() {
            return Highcharts.dateFormat('%Y-%m-%d', this.x) + '<br/>' +
                   '<b>Total Movies: </b>' + Highcharts.numberFormat(this.y, 0);
        }
    }
});    



// Convert PHP data to JavaScript array
const seriesData = <?php echo json_encode($seies_chart_data); ?>;

// Transform data into format required by Highcharts
// Accumulate the counts to show total growth
let totalSeries = 0;
let totalTvShows = 0;
const sData = seriesData.map(item => {
    totalSeries += parseInt(item.series_count || 0);
    totalTvShows += parseInt(item.tvshows_count || 0);
    return [
        new Date(item.date).getTime(),
        totalSeries,
        totalTvShows
    ];
});

// Create the chart
Highcharts.stockChart('series_chart', {
    rangeSelector: {
        buttons: [{
            type: 'day',
            count: 7,
            text: '1w'
        }, {
            type: 'month',
            count: 1,
            text: '1m'
        }, {
            type: 'month',
            count: 3,
            text: '3m'
        }, {
            type: 'month',
            count: 6,
            text: '6m'
        }, {
            type: 'year',
            count: 1,
            text: '1y'
        }, {
            type: 'all',
            text: 'All'
        }],
        selected: 1
    },
    title: {
        text: 'Total Series & TV Shows Growth'
    },
    yAxis: {
        title: {
            text: 'Total Number of Series & Shows'
        },
        min: 0
    },
    series: [{
        name: 'Total Series',
        data: sData.map(point => [point[0], point[1]]),
        tooltip: {
            valueDecimals: 0
        }
    }, {
        name: 'Total TV Shows',
        data: sData.map(point => [point[0], point[2]]),
        tooltip: {
            valueDecimals: 0
        }
    }],
    tooltip: {
        formatter: function() {
            let tooltip = Highcharts.dateFormat('%Y-%m-%d', this.x);
            this.points.forEach(point => {
                tooltip += '<br/><b>' + point.series.name + ': </b>' + 
                          Highcharts.numberFormat(point.y, 0);
            });
            return tooltip;
        },
        split: true
    },
    plotOptions: {
        series: {
            marker: {
                enabled: true,
                radius: 3
            },
            shadow: true
        }
    }
});
</script>