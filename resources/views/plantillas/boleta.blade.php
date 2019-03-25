<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <!-- Styles -->
    <style>
        h1, body{
            font-family: Arial, Helvetica, sans-serif;
            
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10;
        }
        thead > .title > th{
            font-weight: bold;
            text-transform: uppercase;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 15px 0;
        }
        tbody > .details > td {
            font-weight: normal;
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #000;
            padding: 5px 0;
        } 

        .text-center{
            text-align: center;
        }

        .text-left{
            text-align: left;
        }

        .text-right{
            text-align: right;
        }

        .text-normal{
            font-weight: normal;
        }
        .text-bold{
            font-weight: bold;
        }
        .header{    
            width: 100%;
        }
        .header .left{
            text-align: left;
        }
        .header .left .logo{
            width: 150px;
        }
        .header .right{
            border: 1px solid #000;
            padding: 15px 30px;
            width: 250px;
        }
        .header .right .title{
            font-size: 15px;
            font-weight: normal;
        }
        .header .right .number{
            font-size: 18px;
            font-weight: bold;
        }
        .header .empresa{
            width: auto;
        }
        .data-client{
            margin-top: 50px;
            padding: 15px 0;
        }
        .no-padding{
            padding: 0px;
        }
        .no-margin{
            margin: 0px;
        }
    </style>
    
</head>
<body>
    <div class="header">
        <table>
            <tbody>
                <tr>
                    <td class="left">
                        
                        <div class="logo">
                            @if ($empresa['logo'] !== 'logo.png')                                
                            <img src="{{base_path().str_replace('storage','storage/app/public',$empresa['logo'])}}" alt="{{$empresa['name']}}" class="logo"/>
                            @else
                            <img src="{{public_path().'/img/brand/logo.svg'}}" alt="logo" class="logo"/>
                            @endif
                        </div>
                        <div class="empresa">
                            <h4 class="text-normal no-margin">{{$empresa['name']}}</h4>
                            <h5 class="text-normal no-margin">RUC {{$empresa['ruc']}}</h5>
                            <p class="no-margin">Telefono / Celular: {{$empresa['telefono']}}</p>
                            <p class="no-margin">Dirección: {{$empresa['direccion']}}</p>
                        </div>
                      
                    </td>
                    <td class="right text-center">
                        <h3 class="no-margin title"> {{$tipo}} </h3>
                        <p class="no-margin number">{{$comprobante['num_comprobante']}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="data-client">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td>Cliente: </td>
                    <td>{{ $comprobante['nombre'] }}</td>
                    <td>Fecha de emisión: </td>
                    <td>{{$comprobante['fecha_emision']}}</td>
                </tr>
                <tr>
                    <td>DNI: </td>
                    <td>{{$comprobante['num_doc']}}</td>
                    <td>Fecha de vencimiento: </td>
                    <td>{{$comprobante['fecha_emision']}}</td>
                </tr>
                <tr>
                    <td>Dirección: </td>
                    <td>{{$comprobante['direccion']}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <table>
        <thead>
            <tr class="title">
                <th class="text-center" style="width: 100px">Cantidad</th>                                   
                <th class="text-left" style="width: 300px">Descripción</th>
                <th class="text-right">Precio</th>
                <th class="text-right" style="width: 100px">Descuento</th>
                <th class="text-center" style="width: 100px">Unidad</th>
                <th class="text-right" style="width: 100px">Importe</th>
            </tr>            
        </thead>
        <tbody> 
            
            @foreach ($comprobante['details'] as $detail)
                <tr class="details">
                    <td class="text-center">{{$detail['cantidad']}}</td>                                   
                    <td class="text-left">{{$detail['descripcion']}}</td>
                    <td class="text-right">{{$detail['precio']}} </td>
                    <td class="text-right">{{$detail['descuento']}}</td>
                    <td class="text-center">{{$detail['unidad']}}</td>
                    <td class="text-right">{{$detail['subtotal']}}</td>
                </tr>
            @endforeach          
            
            <tr class="text-bold">
                <td colspan="3"></td>                                   
                <td colspan="2" class="text-right">Subtotal: S/</td>
                <td class="text-right">{{$comprobante['subtotal']}}</td>
            </tr>
            <tr class="text-bold">
                <td colspan="3"></td>                                   
                <td colspan="2" class="text-right">IGV: S/</td>
                <td class="text-right">{{$comprobante['igv']}}</td>
            </tr>
            <tr class="text-bold">
                <td colspan="3"></td>                                   
                <td colspan="2" class="text-right">TOTAL A PAGAR: S/</td>
                <td class="text-right">{{$comprobante['total']}}</td>
            </tr>
            <tr>
                <td colspan="6">{{$total_string}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
