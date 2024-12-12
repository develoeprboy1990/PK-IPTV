<style type="text/css">
@import url("https://code.highcharts.com/css/highcharts.css");
@import url("https://code.highcharts.com/dashboards/css/datagrid.css");
@import url("https://code.highcharts.com/dashboards/css/dashboards.css");

#container {
    padding: 10px;
    background-color: var(--highcharts-neutral-color-5);
}

.row {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
}

.cell {
    flex: 1;
    min-width: 20px;
}

.cell > .highcharts-dashboards-component {
    position: relative;
    margin: 10px;
    background-clip: border-box;
    background-color: var(--highcharts-background-color);
}

#kpi-wrapper {
    display: flex;
    flex-direction: column;
}

#kpi-wrapper,
#dashboard-col-0,
#dashboard-col-1,
#dashboard-col-2 {
    flex: 1;
    min-width: 0;
}

#kpi-vitamin-a,
#kpi-iron {
    flex-grow: 1;
}

h1#title {
    padding-top: 10px;
    margin: 0;
    background-color: #3d3d3d;
    text-align: center;
    color: #fff;
}

#kpi-vitamin-a .highcharts-dashboards-component-title::before,
#kpi-iron .highcharts-dashboards-component-title::before {
    width: 14px;
    height: 14px;
    border-radius: 28px;
    display: inline-block;
    padding: 0;
    margin-right: 4px;
    background-color: var(--highcharts-color-0);
    content: " ";
}

#kpi-iron .highcharts-dashboards-component-title::before {
    background-color: var(--highcharts-color-2);
}

#kpi-vitamin-a .highcharts-dashboards-component-kpi-subtitle,
#kpi-iron .highcharts-dashboards-component-kpi-subtitle {
    margin-top: 10px;
    font-size: 1.2em;
    color: var(--highcharts-neutral-color-60);
}

#kpi-vitamin-a .highcharts-dashboards-component-kpi,
#kpi-iron .highcharts-dashboards-component-kpi {
    padding: 10px;
}

#kpi-vitamin-a .highcharts-dashboards-component-kpi-value,
#kpi-iron .highcharts-dashboards-component-kpi-value {
    font-size: 4em;
    line-height: 2.4rem;
    margin-top: 10px;
    color: var(--highcharts-color-0);
}

#kpi-iron .highcharts-dashboards-component-kpi-value {
    color: var(--highcharts-color-2);
}

#dashboard-col-1 .highcharts-color-0 {
    fill: var(--highcharts-color-2);
    stroke: var(--highcharts-color-2);
}

#kpi-vitamin-a .highcharts-dashboards-component-kpi-value::after,
#kpi-iron .highcharts-dashboards-component-kpi-value::after {
    content: "micrograms";
    display: block;
    font-size: 1rem;
}

.highcharts-plot-line {
    stroke-dasharray: 2px;
    stroke: var(--highcharts-color-3);
}

.highcharts-plot-line-label {
    fill: var(--highcharts-color-3);
}

.highcharts-description {
    padding: 0 20px;
}

.highcharts-dashboards-component-kpi-content {
    display: flex;
    flex-direction: column;
}

.highcharts-dashboards-component-kpi {
    min-height: 100px;
    text-align: center;
}

@media (max-width: 992px) {
    .row {
        flex-direction: column;
    }

    #kpi-wrapper {
        flex-direction: row;
        flex: unset;
        width: 100%;
    }
}

@media (max-width: 576px) {
    #dashboard-col-0,
    #dashboard-col-1 {
        flex: unset;
        width: 100%;
    }
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
                        <h3 class="box-title"><?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name); ?>'s Statistics</h3>
                    </div>
                    
                    <div class="box-body">
                        <div id="container">
                            <div class="row">
                                <div id="kpi-wrapper">
                                    <div class="cell" id="kpi-vitamin-a"></div>
                                    <div class="cell" id="kpi-iron"></div>
                                </div>
                                <div class="cell" id="dashboard-col-0"></div>
                                <div class="cell" id="dashboard-col-1"></div>
                            </div>
                            <div class="row">
                                <div class="cell" id="dashboard-col-2"></div>
                            </div>
                        </div>

                        <p class="highcharts-description">
                            The basic dashboard shows the amount of Vitamin A and Iron in foods.<br />
                            *Recommended Dietary Allowance (RDA).
                        </p>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/dashboards/datagrid.js"></script>
<script src="https://code.highcharts.com/dashboards/dashboards.js"></script>
<script src="https://code.highcharts.com/dashboards/modules/layout.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.setOptions({
    chart: {
        styledMode: true
    }
});
Dashboards.board('container', {
    dataPool: {
        connectors: [{
            id: 'micro-element',
            type: 'JSON',
            options: {
                firstRowAsNames: false,
                columnNames: ['Food', 'Vitamin A',  'Iron'],
                data: [
                    ['Beef Liver', 6421, 6.5],
                    ['Lamb Liver', 2122, 6.5],
                    ['Cod Liver Oil', 1350, 0.9],
                    ['Mackerel', 388, 1],
                    ['Tuna', 214, 0.6]
                ]
            }
        }]
    },
    editMode: {
        enabled: true,
        contextMenu: {
            enabled: true
        }
    },
    components: [{
        type: 'KPI',
        renderTo: 'kpi-vitamin-a',
        value: 900,
        valueFormat: '{value}',
        title: 'Vitamin A',
        subtitle: 'daily recommended dose'
    }, {
        type: 'KPI',
        renderTo: 'kpi-iron',
        value: 8,
        title: 'Iron',
        valueFormat: '{value}',
        subtitle: 'daily recommended dose'
    }, {
        sync: {
            visibility: true,
            highlight: true,
            extremes: true
        },
        connector: {
            id: 'micro-element',
            columnAssignment: [{
                seriesId: 'Vitamin A',
                data: ['Food', 'Vitamin A']
            }]
        },
        renderTo: 'dashboard-col-0',
        type: 'Highcharts',
        chartOptions: {
            xAxis: {
                type: 'category',
                accessibility: {
                    description: 'Groceries'
                }
            },
            yAxis: {
                title: {
                    text: 'mcg'
                },
                plotLines: [{
                    value: 900,
                    zIndex: 7,
                    dashStyle: 'shortDash',
                    label: {
                        text: 'RDA',
                        align: 'right',
                        style: {
                            color: '#B73C28'
                        }
                    }
                }]
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    marker: {
                        radius: 6
                    }
                }
            },
            legend: {
                enabled: true,
                verticalAlign: 'top'
            },
            chart: {
                animation: false,
                type: 'column',
                spacing: [30, 30, 30, 20]
            },
            title: {
                text: ''
            },
            tooltip: {
                valueSuffix: ' mcg',
                stickOnContact: true
            },
            lang: {
                accessibility: {
                    chartContainerLabel: 'Vitamin A in food. Highcharts ' +
                        'Interactive Chart.'
                }
            },
            accessibility: {
                description: `The chart is displaying the Vitamin A amount in
                micrograms for some groceries. There is a plotLine demonstrating
                the daily Recommended Dietary Allowance (RDA) of 900
                micrograms.`,
                point: {
                    valueSuffix: ' mcg'
                }
            }
        }
    }, {
        renderTo: 'dashboard-col-1',
        sync: {
            visibility: true,
            highlight: true,
            extremes: true
        },
        connector: {
            id: 'micro-element',
            columnAssignment: [{
                seriesId: 'Iron',
                data: ['Food', 'Iron']
            }]
        },
        type: 'Highcharts',
        chartOptions: {
            xAxis: {
                type: 'category',
                accessibility: {
                    description: 'Groceries'
                }
            },
            yAxis: {
                title: {
                    text: 'mcg'
                },
                max: 8,
                plotLines: [{
                    value: 8,
                    dashStyle: 'shortDash',
                    label: {
                        text: 'RDA',
                        align: 'right',
                        style: {
                            color: '#B73C28'
                        }
                    }
                }]
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    marker: {
                        radius: 6
                    }
                }
            },
            title: {
                text: ''
            },
            legend: {
                enabled: true,
                verticalAlign: 'top'
            },
            chart: {
                animation: false,
                type: 'column',
                spacing: [30, 30, 30, 20]
            },
            tooltip: {
                valueSuffix: ' mcg',
                stickOnContact: true
            },
            lang: {
                accessibility: {
                    chartContainerLabel: 'Iron in food. Highcharts ' +
                        'Interactive Chart.'
                }
            },
            accessibility: {
                description: `The chart is displaying the Iron amount in
                micrograms for some groceries. There is a plotLine demonstrating
                the daily Recommended Dietary Allowance (RDA) of 8
                micrograms.`,
                point: {
                    valueSuffix: ' mcg'
                }
            }
        }
    }, {
        renderTo: 'dashboard-col-2',
        connector: {
            id: 'micro-element'
        },
        type: 'DataGrid',
        sync: {
            highlight: true,
            visibility: true
        },
        dataGridOptions: {
            credits: {
                enabled: false
            }
        }
    }]
}, true);
</script>