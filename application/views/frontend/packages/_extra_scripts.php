<script type="text/javascript">
    $(document).ready(function(){
        $('#packages').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>packages/get_all_packages",
            columns: [
                { data: "name" },
                { data: "device" },
                { data: "status" },
                { data: "edit" }                        
            ]
        });
    });
  </script>`