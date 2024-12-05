<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Migration Management</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Migration History</a></li>
                        <!-- <li ><a href="#tab_3" data-toggle="tab">Manual Query</a></li> -->
                        
                        <!-- <li class="pull-right" style="display: flex; align-items: center; margin-top: 5px;">
                            <div style="margin-right: 10px;">
                                <input type="text" class="form-control" id="migration-search" placeholder="Search migrations..." style="width: 200px;">
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary btn-flat" onclick="searchMigrations()">
                                    <i class="fa fa-search"></i> Search
                                </a>
                            </div>
                        </li> -->
                    </ul>

                    <div class="tab-content">

                        <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                        <?php } ?>

                        <?php if($responce = $this->session->flashdata('error')){ ?>
                            <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $responce;?></div>
                        <?php } ?>

                        

                        <!-- Migration Management Tab -->
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="alert alert-info">
                                                Current Migration Version: <strong><?php echo $current_version; ?></strong>
                                            </div>

                                            <!-- Migration Actions -->
                                            <div class="row">
                                                <!-- Latest Migration -->
                                                <div class="col-md-6">
                                                    <div class="box box-primary">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Run Latest Migration</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <p class="text-muted">This will run all pending migrations to bring the database to the latest version.</p>
                                                            <!-- Latest Migration Form -->
                                                            <?php echo form_open('migration/latest', ['class' => 'form-inline', 'method' => 'post']); ?>
                                                                <button type="submit" class="btn btn-primary btn-flat">
                                                                    <i class="fa fa-play"></i> Run Latest Migration
                                                                </button>
                                                            <?php echo form_close(); ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Revert Last Migration -->
                                                <div class="col-md-6">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Revert Last Migration</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <p class="text-muted">This will revert the last applied migration.</p>
                                                            <!-- Revert Migration Form -->
                                                            <?php echo form_open('migration/revert', ['class' => 'form-inline', 'method' => 'post']); ?>
                                                                <button type="submit" class="btn btn-danger btn-flat" onclick="return confirm('Are you sure you want to revert the last migration? This action cannot be undone.');">
                                                                    <i class="fa fa-undo"></i> Revert Last Migration
                                                                </button>
                                                            <?php echo form_close(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Migration History Tab -->
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <?php if (!empty($migration_history)): ?>
                                                <table id="migration-history" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Version</th>
                                                            <th>Filename</th>
                                                            <th>Action</th>
                                                            <th>Applied At</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=1; foreach ($migration_history as $migration): ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo $migration->version; ?></td>
                                                            <td><?php echo $migration->filename; ?></td>
                                                            <td><?php echo $migration->action; ?></td>
                                                            <td><?php echo $migration->applied_at; ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <div class="alert alert-info">No migration history available.</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="tab-pane" id="tab_3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Run Manual Query</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <p class="text-muted">Enter your SQL query below. Please be cautious when running manual queries.</p>
                                                            <form method="post" action="<?= BASE_URL ?>migration/manual_query">
                                                                <div class="form-group">
                                                                    <textarea name="query" class="form-control" rows="4" placeholder="Enter your SQL query here..." style="font-family: monospace; resize: vertical;" required></textarea>
                                                                </div>
                                                                <div class="form-group" style="margin-top: 10px;">
                                                                    <button type="submit" class="btn btn-info btn-flat" onclick="return confirm('Are you sure you want to execute this query? This action cannot be undone.');">
                                                                        <i class="fa fa-database"></i> Execute Query
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>