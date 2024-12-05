<script type="text/javascript">
    $(document).ready(function(){
        $('#groups').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>groups_channel/get_all_groups_channel",
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "position" },
                { data: "group_edit" },
                { data: "group_delete" }               
            ]
        });
    });
  </script>`