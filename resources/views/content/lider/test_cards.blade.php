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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <style>
        *,
        *::before,
        *::after {
            margin:0;
            padding: 0;
            box-sizing: border-box;
        }
        .card-content{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .container {
            max-width: 100% ;
        }
        
        .catalog__col {
            width: 32% ;
            padding: 1px 50px 0 0 ;
            align-items: center;
            align-content: center;
            align-self: center;
        }
        .card{
            padding: 10px;
            align-items: center;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 0 15px rgba(33,37,41,0.1);
            transition: all 0.3s ease;
            margin-top: 10px;
            
            position: relative;
            max-width: 325px;
            width:280px;
            height:auto;
            overflow: hidden;
        }
        .card:hover {
            box-shadow: 0 0 5px rgba(33,37,41,0.1);
        }
        .card__title {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .card__text {
            flex: 1;
            position:relative;
            padding: 10px 5px 5px;
            margin-bottom: 5px;
        }
        .card__button {
            margin-top: 30px;
            text-align: center;
        }
        .card__button a {
            display: inline-flex;
            padding: 0 30px;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            height: 40px;
            color: #212529;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #f7cb15;
            transition: all 0.3s ease;
            background: #fff;
        }
        .card__button a:hover {
            border-color: transparent;
            background: #f7cb15;
        }
        @media (max-width: 1199.98px) {
            .catalog__col {
                width: 33.33333333% ;
        }
    }
    @media (max-width: 991.98px) {
        .catalog__col {
            width: 50%;
        }
    }
    @media (max-width: 575.98px) {
        .catalog__col {
            width: 100%;
        }
    }
    .container{
        min-height:100px;
        display:flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        align-content: center;
        align-self: center;
    }
    .card__image{
        max-height: 200px;
    }
    .card__image img{
        border-radius: 5%;
        max-width: 100%;
        height: auto;
        align-self: center;
    }
    .pagination-1{
        text-align: center;
        margin: 30px 30px 30px;
        user-select:none;
    }
    .pagination-1 li{
        display:inline-block;
        margin: 5px;
        box-shadow: 0 5px 25px rgb(1 1 1 / 10%);
    }
    .pagination-1 li a{
        color: #fff;
        text-decoration: none;
        font-size: 1.2em;
        line-height: 25px;
    }
    .previous-page, .next-page{
        background: #0AB1CE;
        width: auto;
        border-radius: 45px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .previous-page:hover{
        transform: translateX(-5px);
    }
    .next-page:hover{
        transform: translateX(5px);
    }
    .current-page, .dots{
        background: #ccc;
        width: 45px;
        cursor:pointer;
    }
    .active{
        background: #A3A5A8;
    }
    .disable{
        background: #ccc;
    }
    </style>
</head>
<body>
    <div class="ms-5 mt-3">
    <!-- Layout -->
    <div class="section"> 
    <div class="container">
        <div class="catalog">
            <div class="catalog__flex card-content">
                <div class="catalog__col">
                    <div class=" card">
                        <div class="card__title">Lorem ipsum dolor sit amet</div>
                        <div class="card__image"><img src="https://farm6.staticflickr.com/5730/22609622376_93c3560c8b_m.jpg" alt="sample image"></div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col">
                    <div class="card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod sit amet, consectetur adipisicing elit, sed do eiusmod</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col">
                    <div class=" card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col">
                    <div class=" card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col">
                    <div class=" card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col">
                    <div class=" card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolordo eiusmod</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col">
                    <div class=" card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci expedita eligendi, aut maiores assumenda dolore sapiente, fugit asperiores placeat</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
                </div>
                <div class="catalog__col" style="display:none">
                    <div class=" card">
                        <div class="card__title">Card title</div>
                        <div class="card__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci expedita eligendi, aut maiores assumenda dolore sapiente, fugit asperiores placeat</div>
                        <div class="card__button"><a href="">Button</a></div>
                    </div>
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
</div>
<script type="text/javascript">
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
        var numberOfItems = $('.card-content .card').length;
        var limitPerPage = 3;//cartas visibles por pagina
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
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>
</html>