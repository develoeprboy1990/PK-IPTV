<script type="text/javascript">
    $(document).ready(function(){
        $('#genres').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>series_genres/get_all_genre",
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "edit" },
                { data: "delete" }
            ]
        });
    });
  </script>`