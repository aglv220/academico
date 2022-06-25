<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Carrera</th>
            </tr>
        </thead>
        <tbody id="data">

        </tbody>
</table>
    </div>
    <script>
        function fetch_data(){
            $.ajax({
                url:"<?php echo base_url();?>TestApiControlador/action",
                method: "Post",
                data:{data_action: 'fetch_all'},
                success:function(data){
                    var div = $("#data");
                    div.append(data);
                }
            });
        }
        fetch_data();
    </script>
</body>
</html>