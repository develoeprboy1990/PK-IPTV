<script type="text/javascript">
    $(document).ready(function(){
        $('#packages').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>app_packages/get_all_packages",
            columns: [
                { data: "name" },
                { data: "price" },
                { data: "edit" },
                { data: "delete" }               
            ]
        });
    });
  </script>`