@extends('layouts.index')

@section('content')
    <div style="font-size:22px;padding-bottom:10px;">
        Hola <b>{{$name}}</b> se registro una solicitud para 
        reiniciar la contraseña de tu cuenta.
    </div>
    <div style="padding-top:20px;font-size:17px;text-align: justify">
        Para reiniciar tu contraseña presiona al siguiente boton:
        <br/>
        <div style="padding-top:30px;text-align:center">
        <a style="text-decoration:none;color:#fff;background-color:#434a54;margin:16px auto;border-radius:8px;padding:7px 30px" href='{{env("SYSTEM_URL")}}{{$link}}'>Restablecer contraseña</a>                                                
        </div>                        
    </div>
@endsection

