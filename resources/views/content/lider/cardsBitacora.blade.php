<?php
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
    exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Lider'){
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
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap"rel="stylesheet"
    />
     <link href="{{ asset('css/cardsBitacora.css') }}" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <div class="m-2">
    <p><h1 class='text-center'>Listado de registros</h1></p>
        <h5 >Para filtrar los resultados, por favor seleccione las opciones:</h5>
        <form>
        @csrf
            <div class="input-group mb-3 flex-nowrap">
                <label class="input-group-text fw-bold" for="rama">Rama</label>
                <select class="form-select" name="rama" id="rama">
                    <option value="">---</option>
                <?php 
                foreach($ramas as $r){
                    echo "<option value='".$r->nombre."'>".$r->nombre."</option>";
                }
                ?>
                </select>
                <label class="input-group-text fw-bold" for="trabajo">Trabajo</label>
                <select class="form-select" name="trabajo" id="trabajo">
                <option value="">---</option>
                <?php
                foreach($tipos as $t){
                    echo "<option value='".$t->nomTipo."'>".$t->nombreTrab." ".$t->nomTipo."</option>";
                }
                foreach($trabajos as $t){
                    if($t->nombre != "Levantamiento"){
                        echo "<option value='".$t->nombre."'>".$t->nombre."</option>";
                    }
                }
                ?>
                </select>
            </div>
            <div class="input-group mb-3 flex-nowrap">
                <label class="input-group-text fw-bold" for="ubicacion">Ubicacion</label>
                <select class="form-select" name="ubicacion" id="ubi">
                <option value="">---</option>
                <?php foreach($ubicaciones as $u):?>
                    <option value='{"estado":"<?=$u->estado;?>","ciudad":"<?=$u->ciudad;?>"}'><?=$u->estado;?>, <?=$u->ciudad;?></option>";
                <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mb-3 flex-nowrap">
                <label class="input-group-text fw-bold" for="estatus">Estatus</label>
                <select class="form-select" name="estatus" id="estatus">
                <option value="">---</option>
                    <option value='Terminado'>Terminado</option>
                    <option value='En progreso'>En progreso</option>
                </select>
            </div>
            <div class="input-group mb-3 flex-nowrap">
                <label class="input-group-text fw-bold" for="f_inicio">Fecha inicio</label>
                <input class="form-control" type="date" id="start" name="start" value="<?php $date=date('Y-m-d'); echo $date;?>"min="2019-01-01" max="2030-12-31">
                </div>
                <div class="input-group mb-3 flex-nowrap">
                <label class="input-group-text fw-bold" for="f_inicio">Fecha final</label>
                <input class="form-control"type="date" id="end" name="end" value="<?php $date=date('Y-m-d'); echo $date;?>"min="2019-01-01" max="2030-12-31">
                </div>
                <div class="input-group mb-3 mt-3">
                <button type="button" onclick="busqueda" id='busqueda' name='search' class="mx-auto btn btn-outline-dark btn-lg">Buscar</button>
                </div>
                
        </form>
    </div>
        <div class="container-fluid">
            <div class="section"> 
                <div class="container">
                    <div class="catalog">
                        <div class="catalog__flex card-content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="ms-5 mt-3 pagination-1">
        <!-- <li class="page-item previous-page disable"><a class="page-link" href="#">Anterior</a></li>
        <li class="page-item current-page active"><a class="page-link" href="#">1</a></li>
        <li class="page-item dots"><a class="page-link" href="#">...</a></li>
        <li class="page-item next-page"><a class="page-link" href="#">Siguiente </a></li> -->
    </div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#busqueda").click(function busqueda(){
            $(".card-content").empty();
            $(".pagination-1").empty();
            var rama = document.getElementById("rama").value;
            var trabajo = document.getElementById("trabajo").value;
            var correo = '<?php echo $_SESSION['Correo'] ?>';
            var estatus = document.getElementById("estatus").value;
            var ubicacion = document.getElementById("ubi").value;
            if(ubicacion === ''){
                var ciudad='';
                var estado='';
            }else{
                var ubiJson = JSON.parse(ubicacion);
                var ciudad = ubiJson.ciudad;
                var estado = ubiJson.estado;
            }
            var f_s = document.getElementById("start").value;
            var f_end = document.getElementById("end").value;
            $.ajax({
                type: "POST",
                url: "{{route('query')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    correo: '<?php echo $_SESSION['Correo']?>' ,
                    rama: document.getElementById("rama").value,
                    trabajo: trabajo,
                    status: estatus,
                    ciudad:ciudad,
                    estado:estado,
                    fecha1:f_s,
                    fecha2:f_end
                },
                dataType: "json",
                error: function(error){
                    console.log(JSON.stringify(error));
                },
                success: function(data){ 
                    var length=data.length;
                    data.forEach(item => {
                        switch(item.estatus){
                            case 'En progreso':
                                var progress = $("<div>").addClass('progress').append($("<div>").addClass('progress-bar progress-bar-striped progress-bar-animated').attr({role:"progressbar",style:"width:50%"}).text('En progreso     '));
                                break;
                            case 'Terminado':
                                var progress = $("<div>").addClass('progress').append($("<div>").addClass('progress-bar bg-success progress-bar-striped').attr({role:"progressbar",style:"width:100%"}).text('Terminada'));
                                break;
                        }
                        if(item.trabajo == "Troncal" || item.trabajo == "Enlace" || item.trabajo == "Distribución"){
                            var trab = "Levantamiento "+item.trabajo
                        }else{
                            var trab = item.trabajo;
                        }
                        $(".card-content").append(
                        $("<div>").addClass("catalog__col")
                        .append($("<div>").addClass("card")
                        .append($("<div>").addClass("card__title").append($("<h3>").text("Rama: "+item.rama)).append($("<p>").text(trab)).append($("<h6>").addClass("text-center").text("Ubicación: "+item.ciudad+", "+item.estado))
                        .append($("<div>").addClass("card__text").append($("<h6>").text("Iniciada en: "+item.created_at)).append($("<h6>").text("Modificada el: "+item.updated_at )))
                        .append(progress)).append($("<div>").addClass("card__button").append($("<a>").addClass('card__button_g').attr({href:"../ev/gallery/"+item.id}).text("Galeria"))
                        .append($('<a>').addClass('card__button_m').attr({href:"../bit/mod/"+item.id}).text("Modificar")))//.append($('<a>').addClass('card__button_d').attr({href:"../bit/delV/"+item.id}).text("Eliminar")) )),
                        // );
                        .append('<form  action="<?php echo env("URL")."bit/del/"?>'+item.id+'" method="post">@csrf @method("PUT")<input type="hidden" name="Inactivo" id="inactivo"> <button class ="btn card_button_d" type="submit" id="btndel">Eliminar</button></form>')
                        ));
                });
                function getPageList(totalpages, page, maxLength){
                    function range(start, end){
                        return Array.from(Array(end - start + 1), (_, i) => i + start);
                    }
                    var sideWidth = maxLength < 9 ? 1 : 2;
                    var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
                    var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;
                    
                    if(totalpages <= maxLength){
                        return  range(1, totalpages);
                    }
                    if(page <= maxLength - sideWidth - 1 - rightWidth){
                        return range(1, maxLength - sideWidth - 1).concat(0, range(totalpages - sideWidth + 1, totalpages));
                    }
                    if(page >= totalpages - sideWidth - 1 - rightWidth){
                        return range(1, sideWidth).concat(0, range(totalpages - sideWidth - 1 - rightWidth - leftWidth, totalpages));
                    }
                    return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalpages - sideWidth + 1, totalpages));
                }
                $(function (){
                    var numberOfItems = length;
                    var limitPerPage = 4;//cartas visibles por pagina
                    var totalpages = Math.ceil(numberOfItems / limitPerPage);
                    var paginationSize = 10;//numero de paginas en la paginacion
                    var currentPage;
                    
                    function showPage(whichPage){
                        if(whichPage < 1 || whichPage > totalpages) return false;
                        currentPage = whichPage;
                        $(".card-content .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();
                        $(".pagination-1 li").slice(1, -1).remove();
                        getPageList(totalpages, currentPage, paginationSize).forEach(item => {
                        $("<li>").addClass("page-item").addClass(item ? "current-page" : " dots").toggleClass("active", item === currentPage).append($("<a>"). addClass("page-link").attr({href:"javascript:void(0)"}).text(item || "...")).insertBefore(".next-page");
                    });
                    
                    $(".previous-page").toggleClass("disable", currentPage === 1);
                    $(".next-page").toggleClass("disable", currentPage === totalpages);
                    return true;
                }
                
                $(".pagination-1").append(
                    $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({href:"javascript:void(0)"}).text("Anterior")), 
                    $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({href:"javascript:void(0)"}).text("Siguiente"))
                );
        
                $(".card-content").show();
                showPage(1);
                $(document).on("click", ".pagination-1 li.current-page:not(.active)", function(){
                    return showPage(+$(this).text());
                });
                
                $(".next-page").on("click", function(){
                    return showPage(currentPage + 1);
                });
                
                $(".previous-page").on("click", function(){
                    return showPage(currentPage - 1);
                });});
            }
        });
    });
});    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>
</html>