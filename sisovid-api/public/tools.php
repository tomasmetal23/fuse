<?php

function dump($mixed){
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
}

if(isset($_POST['table']) && $_POST['rows']){
    $table = $_POST['table'];
    $rows = explode("\n",$_POST['rows']);

    $templateCode = "DB::table('status_files')->insert([
            'name' => 'ACTIVO'
        ]);";

    foreach ($rows as $row){
        if(empty($row)){
            continue;
        }
        $row = trim($row);
        $item = " <br/> DB::table('{$table}')->insert([ <br/> "
            . " 'name' => '{$row}' <br/> "
            . " ]);";
        echo $item;
    }

    exit;

}
?>
<html>
    <head>
        <title>tools</title>
    </head>
    <body>

    <form method="post" action="tools.php">

        <div class="form-group-table" style="margin-top: 50px;">
            <label>Ingresa el nombre de la tabla</label>
            <input name="table" type="text">
        </div>

        <div class="form-group-rows">
            <label>Ingresa el contenido</label>
            <br/>
            <textarea name="rows" style="width: 60%; height: 400px;"></textarea>
        </div>

        <div>
            <button>Procesar</button>
        </div>

    </form>

    </body>
</html>

