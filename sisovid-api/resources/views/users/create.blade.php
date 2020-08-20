<div style="background-color:#f4f4f4;padding:20px 50px;">

    <table border="0" cellspacing="0" style="margin:auto;background-color:#fff;width:600px;color:#717171;font-family: helvetica, sans-serif">

        <tr>
            <td style="text-align:center;width:600px">
                <img style="width:150px;margin:15px 0px" src="http://idera-mexico.com/logo-jal.png" />                          
                
            </td>
        </tr>       
        
        <tr>
            <td>
                
                <div style="padding:40px 20px 60px">
                    <div style="font-size:25px;padding-bottom:10px;">
                        Hola <b>{{$name}}</b> se creo un usuario para que puedas ingresar
                        al sistema de la Fiscalia del Estado de Jalisco.
                    </div>
                    <div style="padding-top:20px;font-size:17px;text-align: justify">
                        Datos para ingresar al sistema:
                        <br/>
                        <ul>
                            <li>Usuario: {{$username}}</li>
                            <li>Contrase&ntilde;a: {{$pass}}</li>
                            <li>Link del sistema: <a style="color:#000" href='{{env("SYSTEM_URL")}}'>Ir al sistema</a></li>
                        </ul>                        
                        
                    </div>
                </div> 
                                                
                <div style="font-size:16px;text-align:center;margin: 0px 15px 30px;padding-top:30px">
                    <span style="color:#7b868c">Gobierno del Estado de Jalisco</span>                    
                </div>
                
            </td>
        </tr>

    </table>
    
</div>