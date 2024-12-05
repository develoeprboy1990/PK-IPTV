$(document).ready(function () {
    $('#btn_leftSelected').click(function () {
      // pass id select lists as parameters
      moveItemsToLeft('#multiselect_left', '#multiselect_right');
    });

    $('#btn_rightSelected').on('click', function () {
      moveItemsToRight('#multiselect_left', '#multiselect_right');
    });

    $('#btn_leftAll').on('click', function () {
      moveAllItemsToSource('#multiselect_left', '#multiselect_right');
    });

    $('#btn_rightAll').on('click', function () {
      moveAllItemsToDest('#multiselect_left', '#multiselect_right');
    });

    $('#btn_move_up').click(function(){
      moveUp('#multiselect_right');
    });

    $('#btn_move_down').click(function(){
        moveDown('#multiselect_right');
    });

    //--------- Package Groups-------------------

    $('#btn_leftSelected_package').click(function () {
      // pass id select lists as parameters
      moveItemsToLeft('#multiselect_left_package', '#multiselect_right_package');
    });

    $('#btn_rightSelected_package').on('click', function () {
      moveItemsToRight('#multiselect_left_package', '#multiselect_right_package');
    });

    $('#btn_leftAll_package').on('click', function () {
      moveAllItemsToSource('#multiselect_left_package', '#multiselect_right_package');
    });

    $('#btn_rightAll_package').on('click', function () {
      moveAllItemsToDest('#multiselect_left_package', '#multiselect_right_package');
    });

    $('#btn_move_up_package').click(function(){
      moveUp('#multiselect_right_package');
    });

    $('#btn_move_down_package').click(function(){
        moveDown('#multiselect_right_package');
    });
  });

  function moveItemsToRight(sourseSelect, destSelect) { // move selected items from left to right select list
    $(destSelect).append($(sourseSelect+' option:selected').clone());
    $(destSelect +" option").prop("selected", true); 
    $(sourseSelect+' option:selected').css("display", "none").removeAttr("selected");
    
    var total= $(destSelect +' option').length;
    $(destSelect +'_number').val(total);
  }

  function moveItemsToLeft(sourseSelect, destSelect) { // move back selected items from right to left select list
    $(destSelect+" option:selected").each(function() {
        $(sourseSelect+' option[value='+$(this).val()+']').show().removeAttr("selected");
        $(this).remove();
    });
  
    $(destSelect).each(function(){
          $(destSelect +" option").prop("selected", true); 
    });
    var total= $(destSelect +' option').length;
    $(destSelect +'_number').val(total);
  }

  function moveAllItemsToDest(sourseSelect, destSelect) { // move all items from left to right select list
    $(destSelect).append($(sourseSelect+' option').clone());
    $(sourseSelect+' option').css("display", "none").removeAttr("selected");
    $(destSelect+' option').filter(function() {
      if($(this).css("display") == "none"){
        $(this).remove();
      }
    });

    $(destSelect).each(function(){
          $(destSelect +" option").prop("selected", true); 
    });
    var total= $(destSelect +' option').length;
    $(destSelect +'_number').val(total);
  }

  function moveAllItemsToSource(sourseSelect, destSelect){ // move back all available items from right to left select list
      $(sourseSelect+' option').show().removeAttr("selected");
      $(destSelect+' option').remove();
      var total= $(destSelect +' option').length;
      $(destSelect +'_number').val(total);
  }

  function moveUp(destSelect){ // move selected items one step up in right select list
    var op = $(destSelect+' option:selected');
    op.first().prev().before(op);
  }

  function moveDown(destSelect){ // move selected items one step down in right select list
    var op = $(destSelect+' option:selected');
    op.last().next().after(op);
  }