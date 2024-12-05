<script type="text/javascript">
    $(document).ready(function(){
        $('#role').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>role/get_all_role",
            columns: [
                { data: "id" },
                { data: "role_name" },
                { data: "role_status" },
                { data: "role_edit" },
                { data: "role_delete" },
                { data: "role_create_date"}
            ]
        });
    });
  </script>