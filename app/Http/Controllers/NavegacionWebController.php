<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NavegacionWebController extends Controller
{
    //Inicio
    public function index(){
        return view('Inicio');
    }
    //Galería
    public function galeria(){
        return view('Galeria');
    }
    //Services
    public function servicios(){
        return view('Servicios');
    }
    //Contact
    public function contacto(){
        return view('Contacto');
    }
}
