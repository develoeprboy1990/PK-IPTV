<script type="text/javascript">
  $(document).ready(function(){
    $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

    // mulit-Channels Group
    $('#btn_leftSelected_channels').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_channels', '#multiselect_right_channels');
    });

    $('#btn_rightSelected_channels').on('click', function () {
      moveItemsToRight('#multiselect_left_channels', '#multiselect_right_channels');
    });

    $('#btn_leftAll_channels').on('click', function () {
      moveAllItemsToSource('#multiselect_left_channels', '#multiselect_right_channels');
    });

    $('#btn_rightAll_channels').on('click', function () {
      moveAllItemsToDest('#multiselect_left_channels', '#multiselect_right_channels');
    });

    $('#btn_move_up_channels').click(function(){
      moveUp('#multiselect_right_channels');
    });

    $('#btn_move_down_channels').click(function(){
        moveDown('#multiselect_right_channels');
    });

    // mulit-Movies Group
    $('#btn_leftSelected_movies').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_movies', '#multiselect_right_movies');
    });

    $('#btn_rightSelected_movies').on('click', function () {
      moveItemsToRight('#multiselect_left_movies', '#multiselect_right_movies');
    });

    $('#btn_leftAll_movies').on('click', function () {
      moveAllItemsToSource('#multiselect_left_movies', '#multiselect_right_movies');
    });

    $('#btn_rightAll_movies').on('click', function () {
      moveAllItemsToDest('#multiselect_left_movies', '#multiselect_right_movies');
    });

    $('#btn_move_up_movies').click(function(){
      moveUp('#multiselect_right_movies');
    });

    $('#btn_move_down_movies').click(function(){
        moveDown('#multiselect_right_movies');
    });


    // mulit-Series Group
    $('#btn_leftSelected_series').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_series', '#multiselect_right_series');
    });

    $('#btn_rightSelected_series').on('click', function () {
      moveItemsToRight('#multiselect_left_series', '#multiselect_right_series');
    });

    $('#btn_leftAll_series').on('click', function () {
      moveAllItemsToSource('#multiselect_left_series', '#multiselect_right_series');
    });

    $('#btn_rightAll_series').on('click', function () {
      moveAllItemsToDest('#multiselect_left_series', '#multiselect_right_series');
    });

    $('#btn_move_up_series').click(function(){
      moveUp('#multiselect_right_series');
    });

    $('#btn_move_down_series').click(function(){
        moveDown('#multiselect_right_series');
    });
  });
</script>`