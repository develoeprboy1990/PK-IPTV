<script type="text/javascript">
    $(document).ready(function(){
        $('#songs').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?=BASE_URL?>songs/get_all_songs",
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "album_name" },
                { data: "url" },
                { data: "position" },
                { data: "edit" },
                { data: "delete" }               
            ]
        });
    });
  </script>`