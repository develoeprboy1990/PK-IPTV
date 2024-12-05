<script type="text/javascript">
    $(document).ready(function(){
        $('#stores').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= BASE_URL ?>movie_stores/get_all_store",
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "position" },
                { data: "language_name" },
                { data: "total_movies" }, // Add this line
                { data: "active" },
                { data: "edit" },
                { data: "delete" }
            ]
        });
    });
  </script>`