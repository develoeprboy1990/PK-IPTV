<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

.highcharts-description {
    margin: 0.3rem 10px;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">                 
                    <div class="box-header with-border">
                        <h3 class="box-title">Users Statistics</h3>
                    </div>
                    <div class="box-body">
                    <?php if($responce = $this->session->flashdata('success')){ ?>
                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                    <?php } ?>
                    <div id="result"></div>
                    <div id="scrolling-container" class="table-responsive">
                        <table id="table-sparkline" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>Users</th>
                                <th>Movies</th>
                                <th>Movies per quarter</th>
                                <th>Series</th>
                                <th>Seris per quarter</th>
                                <th>Total</th>
                                <th>Total per quarter</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-sparkline">
                                <?php foreach ($users as $user):?>
                                <tr>
                                    <th>
                                        <a href="<?php echo $user->details_url; ?>"><?php echo htmlspecialchars($user->first_name.' '.$user->last_name, ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </th>
                                    <td><?php echo $user->total_movies; ?></td>
                                    <td data-sparkline="<?php echo $user->movies_quarterly; ?> "/>
                                    <td><?php echo $user->total_series; ?></td>
                                    <td data-sparkline="<?php echo $user->series_quarterly; ?> "/>
                                    <td><?php echo $user->total_difference; ?></td>
                                    <td data-sparkline="<?php echo $user->quarterly_difference; ?> ; column"/>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                  <!-- /.box-body -->
                </div>
             </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box">  
                    <div class="box-header with-border">
                        <h3 class="box-title">Users Bar Chart</h3>
                    </div>               
                    <!-- /.box-header -->
                    <div class="box-body">
                        <figure class="highcharts-figure">
                            <div id="bar_container"></div>
                            <p class="highcharts-description">
                                
                            </p>
                        </figure>
                    </div>
                  <!-- /.box-body -->
                </div>
             </div>
            <div class="col-md-6">
                <div class="box">  
                    <div class="box-header with-border">
                        <h3 class="box-title">Users Column Chart</h3>
                    </div>               
                    <!-- /.box-header -->
                    <div class="box-body">
                        <figure class="highcharts-figure">
                            <div id="column_container"></div>
                             <p class="highcharts-description">
                            </p> 
                        </figure>
                    </div>
                  <!-- /.box-body -->
                </div>
             </div>
        </div>
        
    </section>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script> -->
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
    /**
 * Create a constructor for sparklines that takes some sensible defaults
 * and merges in the individual chart options. This function is also available
 * from the jQuery plugin as $(element).highcharts('SparkLine').
 */
Highcharts.SparkLine = function (a, b, c) {
    const hasRenderToArg = typeof a === 'string' || a.nodeName;
    let options = arguments[hasRenderToArg ? 1 : 0];
    const defaultOptions = {
        chart: {
            renderTo: (
                (options.chart && options.chart.renderTo) ||
                (hasRenderToArg && a)
            ),
            backgroundColor: null,
            borderWidth: 0,
            type: 'area',
            margin: [2, 0, 2, 0],
            width: 120,
            height: 20,
            style: {
                overflow: 'visible'
            },
            // small optimalization, saves 1-2 ms each sparkline
            skipClone: true
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            labels: {
                enabled: false
            },
            title: {
                text: null
            },
            startOnTick: false,
            endOnTick: false,
            tickPositions: []
        },
        yAxis: {
            endOnTick: false,
            startOnTick: false,
            labels: {
                enabled: false
            },
            title: {
                text: null
            },
            tickPositions: [0]
        },
        legend: {
            enabled: false
        },
        tooltip: {
            hideDelay: 0,
            outside: true,
            shared: true
        },
        plotOptions: {
            series: {
                animation: false,
                lineWidth: 1,
                shadow: false,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                marker: {
                    radius: 1,
                    states: {
                        hover: {
                            radius: 2
                        }
                    }
                },
                fillOpacity: 0.25
            },
            column: {
                negativeColor: '#910000',
                borderColor: 'silver'
            }
        }
    };

    options = Highcharts.merge(defaultOptions, options);

    return hasRenderToArg ?
        new Highcharts.Chart(a, options, c) :
        new Highcharts.Chart(options, b);
};

const start = +new Date(),
    tds = Array.from(document.querySelectorAll('td[data-sparkline]')),
    fullLen = tds.length;

let n = 0;

// Creating 153 sparkline charts is quite fast in modern browsers, but mobile
// can take some seconds, so we split the input into chunks and
// apply them in timeouts in order avoid locking up the browser process
// and allow interaction.
function doChunk() {
    const time = +new Date(),
        len = tds.length;

    for (let i = 0; i < len; i += 1) {
        const td = tds[i];
        const stringdata = td.dataset.sparkline;
        const arr = stringdata.split('; ');
        const data = arr[0].split(', ').map(parseFloat);
        const chart = {};

        if (arr[1]) {
            chart.type = arr[1];
        }

        Highcharts.SparkLine(td, {
            series: [{
                data: data,
                pointStart: 1
            }],
            tooltip: {
                headerFormat: '<span style="font-size: 10px">' +
                    td.parentElement.querySelector('th').innerText +
                    ', Q{point.x}:</span><br/>',
                pointFormat: '<b>{point.y}</b>'
            },
            chart: chart
        });

        n += 1;

        // If the process takes too much time, run a timeout
        // to allow interaction with the browser
        if (new Date() - time > 500) {
            tds.splice(0, i + 1);
            setTimeout(doChunk, 0);
            break;
        }
    }
}
doChunk();

// Replace the existing bar chart with this:
Highcharts.chart('bar_container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Movies and Series by User'
    },
    subtitle: {
        text: 'Total count of movies and series per user'
    },
    xAxis: {
        categories: <?php echo json_encode($chart_data['categories']); ?>,
        title: {
            text: null
        },
        gridLineWidth: 1,
        lineWidth: 0
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Items',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineWidth: 0
    },
    tooltip: {
        valueSuffix: ' items'
    },
    plotOptions: {
        bar: {
            borderRadius: '50%',
            dataLabels: {
                enabled: true
            },
            groupPadding: 0.1
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Movies',
        data: <?php echo json_encode($chart_data['movies']); ?>
    }, {
        name: 'Series',
        data: <?php echo json_encode($chart_data['series']); ?>
    }]
});

// Replace the existing column chart with this:
Highcharts.chart('column_container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Movies vs Series Distribution by User'
    },
    subtitle: {
        text: 'Comparison of movies and series counts for each user'
    },
    xAxis: {
        categories: <?php echo json_encode($chart_data['categories']); ?>,
        crosshair: true,
        labels: {
            rotation: -45
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Items'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Movies',
        data: <?php echo json_encode($chart_data['movies']); ?>
    }, {
        name: 'Series',
        data: <?php echo json_encode($chart_data['series']); ?>
    }]
});
</script>