<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>
<div class="container mt-2">
    <img width="50%" style=" display: block;
    margin-left: auto;
    margin-right: auto;
   " src="https://audicont.autsteeltech.com/media/logos/logo-letter-8.png" alt="">
    <h3>Prezado <span class="text-capitalize" style="font-weight:700;">{{$uso->nome}} </span></h3>


    </p>

    <h4 style="font-weight:700;">Recuperação de Senha </h4>

    <ul>
        <li>Email : <span style="font-weight:700;"> {{$uso->email}}</span></li>
        <li>Senha Temporaria  : <span style="font-weight:700;"> {{$uso->senha}}</span></li>
        <li> <span style="font-weight:700;">Obs: Faço login e altere seus dados no perfil do usuario </span>   </li>

    
    </ul>

 
  
<br>



</div>

</html>