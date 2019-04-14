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
            border: 1px solid #000;
            padding: 10px 4px;
        }
        tbody > .details > td {
            font-weight: normal;
            border: 1px solid #000;
            padding: 8px 4px;
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
        .header .right .title{
            font-size: 13px;
            font-weight: bold;
        }
        .header .right .number{
            font-size: 15px;
            font-weight: normal;
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
    
    <div style="width: 100%" >
        <table>
           <tbody>
               <tr class="header">
                    <td class="left">                        
                        <div class="logo">
                            @if ($empresa['logo'] !== 'logo.png')                                
                            <img src="{{base_path().str_replace('storage','storage/app/public',$empresa['logo'])}}" alt="{{$empresa['name']}}" class="logo"/>
                            @else
                            <img src="{{public_path().'/img/brand/logo.svg'}}" alt="logo" class="logo"/>
                            @endif
                        </div>
                        <div class="empresa">                            
                            <h2 class="text-normal no-margin">{{$empresa['name']}}</h2>
                            <p class="no-margin"> RUC: {{$empresa['ruc']}}</p>
                            <p class="no-margin">Telefono / Celular: {{$empresa['telefono']}}</p>
                            <p class="no-margin">Dirección: {{$empresa['direccion']}}</p>                            
                        </div>
                        
                    </td>
                    <td class="right text-right" style="top: 0">
                       <p>Fecha de reporte: 2018-04-15</p>
                    </td>
               </tr>
           </tbody>
        </table>
        <br>
        <table style="width: 100%">
            <thead>
                <tr class="title">
                    <th>#</th>
                    <th>Tipo comprobante</th>
                    <th>Número</th>
                    <th>Fecha emisión</th>
                    <th style="width: auto">Cliente</th>
                    <th>Num. Doc.</th>
                    <th>Estado</th>
                    <th>Moneda</th>
                    <th>T. Gravado</th>
                    <th>T. IGV</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)                        
                <tr class="details"> 
                    <td>{{$number++}}</td>
                    @if ($document['tipo'] === 'FA')
                    <td>Factura</td>
                    @elseif($document['tipo'] === 'BO')
                    <td>Boleta</td>
                    @elseif($document['tipo'] === 'NC')
                    <td>Nota de Crédito</td>
                    @elseif($document['tipo'] === 'ND')
                    <td>Nota de Débito</td>
                    @endif
                    
                    <td>{{$document['num_comprobante']}}</td>
                    <td>{{$document['fecha_emision']}}</td>
                    <td>{{$document['nombre']}}</td>
                    <td>{{$document['tipo_doc']}} - {{$document['num_doc']}}</td>
                    @if ($document['estado'] === 'accepted')
                        <td>Aceptado</td>
                    @elseif($document['estado'] === 'registered')
                        <td>Registrado</td>
                    @elseif($document['estado'] === 'canceled')
                        <td>Anulado</td>
                    @endif                       
                    <td>PEN</td>
                    <td>{{$document['subtotal']}}</td>
                    <td>{{$document['igv']}}</td>
                    <td>{{$document['total']}}</td>
                </tr>
                @endforeach                  
            </tbody>
        </table>
    </div>
</body>
</html>
