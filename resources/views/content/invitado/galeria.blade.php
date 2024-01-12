<?php
// dd($evidencias);
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
            exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Invitado'){
    header('Location: '.env('URL').'login ');
            exit();
}
$tipoUs=$_SESSION['TipoUs'];?>
@include('layouts.sidebarDashboard')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
    <title>Galeria</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
    body{
        font-family: 'Poppins';
    }
    a:hover{
        color: white !important;
    }
</style>

<body>
    <div class="ms-3 mt-3 text-start container">
        <a class="btn btn-outline-dark align-item-center" href='<?php echo env('URL').'inv/inicio';?>'><span
                class="ms-1 d-sm-inline bi bi-arrow-bar-left fs-4"></span>&nbsp;Regresar</a>
    </div>
    <div class="p-3 container">
        <h2 class="text-center mb-4">
            Galería de Evidencias
            <br><br>
            {{$bitacora->nomRama}}&nbsp;
            @if ($bitacora->trab == 'Troncal' || $bitacora->trab == 'Enlace' || $bitacora->trab == 'Distribución')
            Levantamiento {{$bitacora->trab}}<br>{{$bitacora->ciudad}},&nbsp;{{$bitacora->estado}}
            @else
            {{$bitacora->trab}}<br>{{$bitacora->ciudad}},&nbsp;{{$bitacora->estado}}
            @endif
        </h2>
    </div>
    <div class="ms-5 mt-3">
        @if (!isset($message))
        <div class='ms-3 mt-3 text-end me-2'>
            <div class="d-inline-flex">
                <form action='{{route("kml")}}' method="post">
                    @csrf
                    @method('post')
                    <?php
                    echo '<input type="hidden" name="id" value='.$id_bit.'>';
                ?>
                    <button type="submit" class="btn btn-outline-primary">Descargar kml*</button>
                    <p class="text-muted">* el kml contiene todos los puntos listados</p>
                </form>
            </div>
            <div class="d-inline-flex">
                <form action='{{route("xls")}}' method="post">
                    @csrf
                    @method('post')
                    <?php
                    echo '<input type="hidden" name="id" value='.$id_bit.'>';
                ?>
                    <button type="submit" class="btn btn-outline-success">Descargar excel</button>
                    <!-- <p class="text-muted">* el kml contiene todos los puntos listados</p> -->
                </form>
            </div>
        </div>
    </div>
    </div>
    <br> <br>

    <div class="container-fluid mt-3">
        <div class="row" id="cards">
            <?php
    // $i = 0;
    foreach($evidencias as $ev){
    echo '
            <div class="col-12 col-md-6 col-lg-3 carta">
                <div class="card mb-2">
                    
                    <img src="'.$ev->foto.'" class="card-img-top img-fluid modal-image" data-toggle="modal" data-url="'.$ev->foto.'" data-target="#photoModal" id="foto" data-card-title="'.$ev->nombre.'">
                    <div class="card-body">
                        <h5 style="font-size:1.25rem;" class="card-title">'.$ev->nombre.'</h5>
                        <p class="card-text" style="font-size:1rem;">'.$ev->descripcion.'</p>
                        <p class="card-text" style="font-size:1rem;"><small class="text-muted">Ultima modificación: '.$ev->updated_at.'</small></p>
                        <a href="'.route('EvidenciaInv', $ev->id).'" class="btn btn-outline-warning" style="color: yellow;">Ver
                            más</a>
                    </div>
                </div>
            </div>
           ';
    }
    ?>
        </div>
    </div>
    @else
    <div class="p-3 container mt-4">
        <h3 class="text-center mensaje">{{$message}}</h3>
    </div>
    @endif
    <!-- Modal -->
    <div class="modal" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="card-img-top img-fluid d-block h-100">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <nav class="pagination-buttons" id="pagination-buttons">
            <ul class="justify-content-center pagination mt-4">
                <li class="page-item">
                    <button class="page-link" id="prev-button">Anterior</button>
                </li>
                <li class="page-item">
                    <button class="page-link" id="next-button">Siguiente</button>
                </li>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Get all images with class "modal-image"
  var images = document.querySelectorAll('.modal-image');
  
  // Add click event listener to each image
  images.forEach(img => {
    img.addEventListener('click', function(){
      // Get the url of the clicked image
      var cardTitle = $(this).data('card-title');
      var url = img.getAttribute('data-url');
      console.log(url);
      // Get the modal's image element
      document.getElementById("photoModalLabel").innerHTML = cardTitle;
      var modalImg = document.querySelector('.modal-body img');
      $("#photoModalLabel").html(cardTitle);
      // Set the src of the modal's image element to the url of the clicked image
      modalImg.src = url;
    });
  });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const message = document.querySelector('.mensaje');
        const pagination = document.querySelector('.pagination-buttons');
        if (message && message.innerHTML === "No existen evidencias") {
            pagination.style.display = "none";
        } else {
            pagination.style.display = "block";
            const cards = document.querySelectorAll('.carta');
            const cardsPerPage = 4;
            let currentPage = 1;
            const totalPages = Math.ceil(cards.length / cardsPerPage);
            showPage(1);
            function showPage(page) {
            currentPage = page;
            if(currentPage < 1) { currentPage=1; } const startIndex=(currentPage - 1) * cardsPerPage; const endIndex=startIndex +
                cardsPerPage; cards.forEach((card, index)=> {
                if (index >= startIndex && index < endIndex) { card.style.display='block' ; } else { card.style.display='none' ; }
                    }); updatePaginationButtons(); } function updatePaginationButtons() { const
                    prevButton=document.getElementById('prev-button'); const nextButton=document.getElementById('next-button'); if
                    (currentPage<=1) { prevButton.disabled=true; } else { prevButton.disabled=false; } if (currentPage>=totalPages)
                    {
                    nextButton.disabled = true;
                    } else {
                    nextButton.disabled=false;
                    }
                    }
                    document.getElementById('prev-button').addEventListener('click', function () {
                    currentPage--;
                    showPage(currentPage);
                    });
                    document.getElementById('next-button').addEventListener('click', function () {
                    currentPage++;
                    showPage(currentPage);
                    });
            
                    function createPageButtons(totalPages, pagination) {
                    const nextButton = pagination.querySelector('#next-button').parentElement;
                    for (let i = 1; i <= totalPages; i++) { if(i===1 || i===totalPages || Math.abs(i - currentPage) <=2 ) { let
                        li=document.createElement('li'); li.classList.add('page-item'); let a=document.createElement('button');
                        a.classList.add('page-link'); a.textContent=i; a.addEventListener('click', ()=> showPage(i));
                        li.appendChild(a);
                        pagination.insertBefore(li, nextButton);
                        }
                        }
                        }
                        createPageButtons(totalPages, document.querySelector('.pagination'));
        }
    });
    </script>
</body>
</html>
