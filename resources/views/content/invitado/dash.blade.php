@include('layouts.scripts')
<?php
session_start();
        $_SESSION['TipoUs']=$tipoUs;
        $_SESSION['Estatus']=$estatusUsuario;
        $_SESSION['Correo']=$correoUs;
        $_SESSION['dash']='true';
        $_SESSION['invitados']=$invitados;
?>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
  
    <title>Dash Invitado</title>
</head>
<body>
    <div class="ms-5 mt-3">
        
    </div>
    
    <?php

    $time_start = microtime(true);
    // Sleep for a while
    usleep(100000);
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    if($time>0.005){
        header('Location: '.env('URL').'inv/inicio ');
        exit();
    }
    ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>
</html>