<script type="text/javascript">
    $(document).ready(function(){
        $('#categories').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>app_categories/get_all_cat",
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "edit" },
                { data: "delete" }
            ]
        });
    });
  </script>`