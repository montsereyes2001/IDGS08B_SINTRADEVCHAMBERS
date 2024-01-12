@extends('layouts.scripts')
<h1>Recuperación de contraseña</h1>
Puedes crear una nueva contraseña haciendo click en el siguiente enlace:
<a href="{{ route('reset.password.get',$token)}}">Recuperar contraseña</a>