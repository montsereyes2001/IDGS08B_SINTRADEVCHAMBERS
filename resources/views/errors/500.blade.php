<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="icon" href="{{URL::asset('/assets/logo.png')}}">
</head>
<style>
 @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

html, body {
  width:100%;
  height:100%;
}

body {
 
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  min-height: 100vh;
  background-color: rgb(4,52,84);
  overflow: hidden;
}

  body:before,
  body:after {
    content: "";
    position: absolute;
    left: 50%;
    min-width: 300vw;
    min-height: 300vw;
    background-color:rgb(71, 136, 180);
    animation-name: rotate;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
  }
  
  body:before {
    bottom: 15vh;
    border-radius: 45%;
    animation-duration: 10s;
  }
  
  body:after {
    bottom: 12vh;
    opacity: .5;
    border-radius: 47%;
    animation-duration: 10s;
  }

@keyframes rotate {
  0% {transform: translate(-50%, 0) rotateZ(0deg);}
  50% {transform: translate(-50%, -2%) rotateZ(180deg);}
  100% {transform: translate(-50%, 0%) rotateZ(360deg);}
}

h1, h2, a {
  color: #ffffff;
  z-index: 10;
  margin: 0;
  font-weight: 300;
  line-height: 1.3;
  text-align: center;
}

h1 {
  margin-top:24px;
  font-size: 66px;
  font-weight:700;
  text-align:center;
   font-family: 'Poppins';
}

h2 {
  font-size: 22px;
  text-align:center;
}
a { 
    margin-top:24px;
    font-size: 22px;
  text-align:center;
    align-self: center;
     font-family: 'Poppins';
}

.circle {
  position: relative;
  overflow: hidden;
  width: 500px;
  height: 300px;
  margin-bottom: -100px;
  background: transparent;
  box-shadow: #ffffff;
  z-index:99;  
}
</style>
<body>
    <div class="spin circle text-center">
        <h1>Error 500</h1>
        <h2>Lo sentimos, el servidor no está funcionando en este momento inténtalo más tarde.</h2>
    </div>
</body>
</html>