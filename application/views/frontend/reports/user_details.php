<style type="text/css">
.stats-box {
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.chart-container {
    min-height: 300px;
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
                        <!-- Summary Cards -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-film"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Movies</span>
                                        <span class="info-box-number"><?php echo $yearly_stats[date('Y')]['total_movies']; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-tv"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Series</span>
                                        <span class="info-box-number"><?php echo $yearly_stats[date('Y')]['total_series']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Yearly Charts -->
                        <?php foreach ($yearly_stats as $year => $stats): ?>
                        <div class="stats-box">
                            <h4><?php echo $year; ?> Statistics</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="movies-chart-<?php echo $year; ?>" class="chart-container"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="series-chart-<?php echo $year; ?>" class="chart-container"></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php foreach ($yearly_stats as $year => $stats): ?>
    // Movies Chart
    Highcharts.chart('movies-chart-<?php echo $year; ?>', {
        title: {
            text: '<?php echo $year; ?> Quarterly Movies'
        },
        xAxis: {
            categories: ['Q1', 'Q2', 'Q3', 'Q4']
        },
        yAxis: {
            title: {
                text: 'Number of Movies'
            }
        },
        series: [{
            name: 'Movies',
            data: [<?php echo $stats['movies_quarterly']; ?>]
        }]
    });

    // Series Chart
    Highcharts.chart('series-chart-<?php echo $year; ?>', {
        title: {
            text: '<?php echo $year; ?> Quarterly Series'
        },
        xAxis: {
            categories: ['Q1', 'Q2', 'Q3', 'Q4']
        },
        yAxis: {
            title: {
                text: 'Number of Series'
            }
        },
        series: [{
            name: 'Series',
            data: [<?php echo $stats['series_quarterly']; ?>]
        }]
    });
    <?php endforeach; ?>
});
</script>