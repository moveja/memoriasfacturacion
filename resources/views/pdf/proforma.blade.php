
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FACTURA</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
</head>
<body>
<section class="header" style="top: -287px">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td colspan="2" class="text-center">
                <span style="font-size: 25px; font-weight: bold;">MEMORIAS SUPPLY</span>
            </td>
        </tr>
        <tr>
            <td width="45%" style="vertical-align: top; padding-top: 10px; position: relative">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="" class="invoice-logo"><!--LOGO DE la empresa-->
            </td>
            <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px">
                <span style="font-size: 16px"><strong>PROFORMA DE VENTA</strong></span>
                <br>
                <span style="font-size: 16px"><strong>SIN DERECHO A CREDITO FISCAL</strong></span>
                <br>
                <span style="font-size: 10px">AV. 6 DE AGOSTO, SHOPPING QUINTO CENTENARIO</span>
                <br>
                <span style="font-size: 10px">LOCAL: 14, 15 Y 16</span>
                <br>
                <span style="font-size: 10px">Tel: 75268368</span>
                <br>
                <span style="font-size: 10px">NIT: 6103746013</span>
                <br>
                <span style="font-size: 10px">No: {{$saleId}}</span>
                <br>      
                <span style="font-size: 10px">Fecha: {{\Carbon\Carbon::now()->format('d-M-Y')}}</span>
                <br>           
            </td>
            <br>
        </tr>
    </table>
</section>
<br>
<br>
<br>
<br>

<section style="margin-top: -110px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <thead>
            <tr>
                <th width="10%">CANT</th>
                <th width="40%">DESCRIPCIÓN</th>
                <th width="20%">PRECIO</th>
                <th width="20%">TOTAL BS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalle as $d)
                <tr>
                    <td align="center">{{number_format($d->quantity,0)}}</td>
                    <td align="center">{{$d->product}}</td>
                    <td align="center">{{number_format($d->price,2)}}</td>
                    <td align="center">{{number_format($d->quantity * $d->price, 2)}}</td>
                </tr>
            @endforeach                
        </tbody>

        <tfoot>

            <tr>
                <td class="text-center">
                <b> {{$detalle->sum('quantity')}}</b>
                </td>
                <td></td>    
                <td class="text-center">
                    <span><b>TOTAL A PAGAR</b></span>
                </td>
                                @if($detalle)
                                @php $mytotal = 0; @endphp
                                @foreach($detalle as $d)
                                @php
                                $mytotal += $d->quantity * $d->price;
                                @endphp
                                @endforeach
                                <td class="text-center"><b>Bs.{{number_format($mytotal,2)}}<b></td>
                                @endif          
            </tr>
        </tfoot>
    </table>
</section>

<section>
    <table cellpadding="0" cellspacing="0" width="100%">

        <tr>
            <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px">
                <br>
                <span style="font-size: 10px">Esta factura no tiene derecho a credito fiscal</span>
            </td>
            <br>
        </tr>
    </table>
</section>

<section class="footer">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <tr>
            <td width="20%">
                <span>MEMORIAS SUPPLY</span>
            </td>
            <td class="text-center" width="60%">
                memoriasclub.com
            </td>
            <td class="text-center" width="20%">
                pagina <span class="pagenum"></span>
            </td>
        </tr>
    </table>
</section>
    
</body>
</html>