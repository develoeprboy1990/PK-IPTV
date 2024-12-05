<script type="text/javascript">
    $(document).ready(function(){
        $('#employee').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>employee/get_all_emp",
            columns: [
                { data: "id" },
                { data: "employee_name" },
                { data: "employee_status" },
                { data: "employee_edit" },
                { data: "employee_delete" },
                { data: "employee_create_date"}
            ]
        });
    });
  </script>`