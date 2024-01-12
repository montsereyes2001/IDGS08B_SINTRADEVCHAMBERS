<?php
function getGps($exifCoord,  $hemi) {

$degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
$minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
$seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;

$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

}

function gps2Num($coordPart) {

$parts = explode('/', $coordPart);

if (count($parts) <= 0)
    return 0;

if (count($parts) == 1)
    return $parts[0];

return floatval($parts[0]) / floatval($parts[1]);
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
body{
    font-family: 'Poppins';
}

</style>
<body>
<div class="container">
        <form action="#" class="" enctype="multipart/form-data">
            <div class="mb-3 row row-cols-2">
                <label for="" class="form-label col-12">Agregar foto..</label>
                <div class="col-10">
                    <input class="form-control" type="file" name="image" id="">
                </div>
                
                <button type="submit" name="submit" class="col-2 btn btn-outline-primary align-item-center">Enviar</button>
            
            </div>
            <!-- <div class="col-2">
                <label type="" for="" class="form-label">Subir Imagenes</label>
                <button type="submit" name="submit" class=" col-12 btn btn-outline-primary align-item-center" id="btn-reg">Enviar</button>
            </div> -->
        </form> 
        <?php
            // if(isset($_POST['submit'])){
                if(getimagesize($_FILES['image']['tmp_name'])==FALSE){
                    echo "Please select an image.";
                }
                else{
                    $temp = $_FILES['image']['tmp_name'];
                    $size = $_FILES['image']['size'];
                    $name = $_FILES['image']['name'];
                    $imgsubida = fopen($temp, 'r');
                    $imgbin = fread($imgsubida, $size);
                    // saveimage($name, $imgbin, $temp);

                    $exif= exif_read_data($temp);
                    //if (array_key_exists("GPSLatitude",$exif)){
                    $lat=getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
                    $lon=getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
                    $alt = gps2Num($exif["GPSAltitude"]);
                    
                    move_uploaded_file($temp, "storage/app/public/evidencias".$name);
                    
                    echo'
                    
                    <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="..." alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <?php
                        
                        <p class="card-text">lat: '.$lat.' long: '.$lon.' alt: '.$alt.' </p>
                        ?>
                        <p class="card-text"></p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                    ';

                }
            // }


        ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>

</body>
</html>
