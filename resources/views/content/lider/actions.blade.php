@include('layouts.scripts')
<?php
session_start();
if(!isset($_SESSION['dash']))
{
  header('Location: '.env('URL').'login ');
  exit();
}else{
    if(isset($list) && isset($action)){
        $_SESSION['listado'] = $list;
        $time_start = microtime(true);
        // Sleep for a while
        usleep(100000);
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        if($time>0.005){
          //ruta que regrese solo la vista de la tabla de sup asignados
          switch ($action) {
            case "register":
              header('Location: '.env('URL').'bit/list');
              break;
            case "list":
              header('Location: '.env('URL').'bit/show');
              break;
            case "list_cards":
              header('Location: '.env('URL').'bit/cards');
              break;
              case 'borrarBitacora' :
              header('Location: '.env('URL').'bit/cards');

              break;
          }
          exit();            
        }
    }elseif(isset($evidencias)){
      $_SESSION['evidencias'] = $evidencias;
      $_SESSION['bit']=$id_bit;
      $time_start = microtime(true);
        // Sleep for a while
        usleep(100000);
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        if($time>0.005){
          header('Location: '.env('URL').'ev/listado');
          exit();
        }
    }
}
?>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
  <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
  </style>
    <title>Actions</title>
</head>
<body>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>
</html>