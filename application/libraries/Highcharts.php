<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Highcharts {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function pie_chart($container, $data)
    {
        $series_data = [];
        foreach ($data as $key => $value) {
            $series_data[] = [
                'name' => ucfirst($key),
                'y' => $value
            ];
        }

        $chart_config = [
            'chart' => [
                'plotBackgroundColor' => null,
                'plotBorderWidth' => null,
                'plotShadow' => false,
                'type' => 'pie'
            ],
            'title' => [
                'text' => 'Distribution'
            ],
            'tooltip' => [
                'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>'
            ],
            'accessibility' => [
                'point' => [
                    'valueSuffix' => '%'
                ]
            ],
            'plotOptions' => [
                'pie' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => [
                        'enabled' => true,
                        'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'
                    ]
                ]
            ],
            'series' => [[
                'name' => 'Distribution',
                'colorByPoint' => true,
                'data' => $series_data
            ]]
        ];

        return $this->generate_chart_js($container, $chart_config);
    }

    public function bar_chart($container, $data)
    {
        $categories = array_keys($data);
        $series_data = array_values($data);

        $chart_config = [
            'chart' => [
                'type' => 'column'
            ],
            'title' => [
                'text' => 'Distribution'
            ],
            'xAxis' => [
                'categories' => $categories
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Count'
                ]
            ],
            'series' => [[
                'name' => 'Count',
                'data' => $series_data
            ]]
        ];

        return $this->generate_chart_js($container, $chart_config);
    }

    public function line_chart($container, $data, $title = 'Time-based Statistics', $yAxisTitle = 'Count', $series_keys = ['count'])
    {
        $categories = array_column($data, 'date');
        $series_data = [];

        foreach ($series_keys as $key) {
            $series_data[] = [
                'name' => ucfirst(str_replace('_', ' ', $key)),
                'data' => array_map('intval', array_column($data, $key))
            ];
        }

        $chart_config = [
            'chart' => [
                'type' => 'line'
            ],
            'title' => [
                'text' => $title
            ],
            'xAxis' => [
                'categories' => $categories
            ],
            'yAxis' => [
                'title' => [
                    'text' => $yAxisTitle
                ]
            ],
            'series' => $series_data
        ];

        return $this->generate_chart_js($container, $chart_config);
}

    private function generate_chart_js($container, $config)
    {
        $json_config = json_encode($config);
        return "
            if (document.getElementById('$container')) {
                Highcharts.chart('$container', $json_config);
            } else {
                console.error('Container not found: $container');
            }
        ";
    }
}