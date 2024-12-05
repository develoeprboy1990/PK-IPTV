<script type="text/javascript">
    $(document).ready(function(){
        $('#user').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>user/get_all_users",
            columns: [
                { data: "id" },
                { data: "user_name" },
                { data: "user_employee" },
                { data: "user_group" },
                { data: "user_status" },
                { data: "user_edit" },
                { data: "user_delete" },
                { data: "user_create_date"}
            ]
        });
    });
  </script>