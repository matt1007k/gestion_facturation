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
                            <img src="img/brand/logo.svg" alt="" class="logo"/>
                        </div>
                        <div class="empresa">
                            <h4 class="text-normal no-margin">Demo</h4>
                            <h5 class="text-normal no-margin">RUC 11010101010</h5>
                            <p class="no-margin">Telefono: 985685261</p>
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
        <table>
            <tbody>
                <tr>
                    <td>Cliente: </td>
                    <td>{{ $comprobante['nombre'] }}</td>
                    <td>Fecha de emisión: </td>
                    <td>{{$comprobante['fecha_emision']}}</td>
                </tr>
                <tr>
                    <td>RUC: </td>
                    <td>{{$comprobante['num_doc']}}</td>
                    <td>Fecha de vencimiento: </td>
                    <td>{{$comprobante['fecha_emision']}}</td>
                </tr>
                <tr>
                    <td>Dirección: </td>
                    <td>{{$comprobante['direccion']}}</td>
                </tr>
                {{-- <tr style="margin-top: 10px;padding: 15px 0;">
                    <td>Orden de Compra:  </td>
                    <td>12</td>
                    <td></td>
                    <td></td>
                </tr> --}}
            </tbody>
        </table>
    </div>
    <table>
        <thead>
            <tr class="title">
                <th class="text-center">Canti.</th>                                   
                <th class="text-left">Descripción</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Descuento</th>
                <th class="text-right">Sub. total</th>
                <th class="text-right">IGV</th>
                <th class="text-right">Importe</th>
            </tr>            
        </thead>
        <tbody> 
            
            @foreach ($comprobante['details'] as $detail)
                <tr class="details">
                    <td class="text-center">{{$detail['cantidad']}}</td>                                   
                    <td class="text-left">{{$detail['descripcion']}}</td>
                    <td class="text-right">{{$detail['precio']}} </td>
                    <td class="text-right">{{$detail['descuento']}}</td>
                    <td class="text-right">{{$detail['subtotal']}}</td>
                    <td class="text-right">{{$detail['subtotal'] * 0.18}}</td>
                    <td class="text-right">{{$detail['subtotal'] + ($detail['subtotal'] * 0.18)}}</td>
                </tr>
            @endforeach          
            
            <tr class="text-bold">
                    <td colspan="4"></td>                                   
                    <td colspan="2" class="text-right">Subtotal: S/</td>
                    <td class="text-right">{{$comprobante['subtotal']}}</td>
                </tr>
            <tr class="text-bold">
                <td colspan="4"></td>                                   
                <td colspan="2" class="text-right">IGV: S/</td>
                <td class="text-right">{{$comprobante['igv']}}</td>
            </tr>
            <tr class="text-bold">
                <td colspan="4"></td>                                   
                <td colspan="2" class="text-right">TOTAL A PAGAR: S/</td>
                <td class="text-right">{{$comprobante['total']}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
