<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($is_allow)) {
   redirect('login', 'refresh');
}
?> 
<style>
    .table-responsive {
  overflow-x: auto;
  min-height: 0.01%; /* Prevents content jump */
}

.dataTables_wrapper {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

/* Make columns more compact */
.table > thead > tr > th,
.table > tbody > tr > td {
  padding: 8px 4px;
  white-space: nowrap;
  font-size: 13px;
}


.btn-group {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
}


.btn-group .btn {
  padding: 2px 4px;
  font-size: 11px;
}

@media (max-width: 768px) {
  .btn-group {
    flex-direction: column;
    gap: 5px;
  }
  
  .btn-group .btn {
    width: 100%;
  }
}

.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    margin-left: -50%;
    text-align: center;
    background: rgba(255,255,255,0.9);
}

.column-filter-buttons {
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #f9f9f9;
}

.column-filter-buttons label {
    margin-right: 15px;
    font-weight: normal;
}

/* Add to existing style section */
.select[multiple] {
  height: 200px !important;
  overflow-y: auto;
}

.tags-platforms-container {
  display: flex;
  gap: 10px;
}

.tags-platforms-container > div {
  flex: 1;
  min-width: 0;
}

.tags-platforms-container select {
  width: 100%;
  height: 200px !important;
}

/* Make text wrap in table cells for Tags and OTT Platforms */
.table > tbody > tr > td:nth-child(6),
.table > tbody > tr > td:nth-child(7),
.table > tbody > tr > td:nth-child(8) {
  white-space: normal;
  min-width: 150px;
  max-width: 200px;
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
                    <div class="box-header">
                        <h3 class="box-title">Movies Management</h3>
                        
                        <div class="pull-right">
                        <?php if($is_allow->allow_create) { ?> 
                            <?php echo anchor('movies/create/'.(isset($type) ? $type : ""), 
                                '<i class="fa fa-plus"></i> '.$add_text, 
                                array('class' => 'btn btn-primary btn-sm')); 
                            ?>
                        <?php } ?>
                            <button id="showsearchoptionbm" class="btn btn-info btn-sm" onclick="showsearchoption()">
                                View Details ↑
                            </button>
                        </div>
                    </div>

                    <!-- Column Visibility Controls (Hidden by default) -->
                    <div class="box-body column-filter-buttons" id="searchbm_select" style="display: none;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Show/Hide Columns</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><input type="checkbox" id="store" checked> Store</label><br>
                                        <label><input type="checkbox" id="movie_tag" checked> Tags</label><br>
                                        <label><input type="checkbox" id="movie_gen" checked> Genres</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label><input type="checkbox" id="poster" checked> Poster</label><br>
                                        <label><input type="checkbox" id="backdrop"> Backdrop</label><br>
                                        <label><input type="checkbox" id="myear"> Year</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label><input type="checkbox" id="mcast"> Movie Cast</label><br>
                                        <label><input type="checkbox" id="trailer"> Trailer</label><br>
                                        <label><input type="checkbox" id="language" checked> Language</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label><input type="checkbox" id="rating" checked> Rating</label><br>
                                        <label><input type="checkbox" id="crating"> Content Rating</label><br>
                                        <label><input type="checkbox" id="user_id"> User</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Filters -->
                    <!-- <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control custom-filter" id="store-filter">
                                    <option value="">All Stores</option>
                                    <?php foreach($store as $id => $name): ?>
                                        <option value="<?php echo str_replace('id_', '', $id); ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control custom-filter" id="language-filter">
                                    <option value="">All Languages</option>
                                    <?php foreach($languages as $id => $name): ?>
                                        <option value="<?php echo str_replace('lang_', '', $id); ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <!-- Flash Messages -->
                    <div class="box-body">
                        <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $responce;?>
                            </div>
                        <?php } ?>

                        <?php if($this->session->flashdata('failure')){ ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $this->session->flashdata('failure');?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- DataTable -->
                    <div class="box-body table-responsive">
                    	<table id="movies" class="table table-bordered table-striped"  style="width:100%">
						    <thead>
						        <tr>
						            <th>ID</th>
						            <th>Name</th>
						            <th>Poster</th>
						            <th class="backdrop-column">Backdrop</th>
						            <th>Store</th>
						            <th>Tags</th>
						            <th>Genres</th>
						            <th>OTT Platforms</th>
						            <th>Language</th>
						            <th>Year</th>
						            <th>Movie Cast</th>
						            <th>Trailer</th>
						            <th>Rating</th>
						            <th>Content Rating</th>
						            <th>Show Home</th>
						            <th>Status</th>
                                    <th>User</th>
						            <th>Actions</th>
						        </tr>
						    </thead>
						    <tbody>
						        <!-- DataTables will populate this -->
						    </tbody>
			             </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Video Player Modal -->
<div class="modal fade" id="videoPlayerModal" tabindex="-1" role="dialog" aria-labelledby="videoPlayerModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="videoPlayerModalLabel">Video Player</h4>
            </div>
            <div class="modal-body">
                <div id="videoContainer" style="position: relative;">
                    <video id="videoPlayer" controls style="width: 100%;">
                        Your browser does not support the video tag.
                    </video>
                    <div id="videoStats" style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 10px; font-size: 12px; display: none;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php if($movie_url_permission && $movie_url_permission->allow_view == 1): ?>
                    <button id="copyUrlBtn" class="btn btn-sm btn-primary">
                        <i class="fa fa-copy"></i> Copy URL
                    </button>
                <?php endif; ?>
                <select id="videoSelector" class="form-control" style="display: inline-block; width: auto;">
                    <option value="">Select Video</option>
                </select>
            </div>
        </div>
    </div>
</div>