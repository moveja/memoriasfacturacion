
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de inventario</title>
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
            <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="" class="invoice-logo"><!--LOGO DE la empresa-->
            </td>

            <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px">
                
                <span style="font-size: 16px"><strong>Reporte de Ventas por Fechas</strong></span>
    

                
            </td>
        </tr>

    </table>
</section>
<section style="margin-top: -110px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <thead>
            <tr>
                <th>PRODUCTO</th>
                <th width="12%">CODIGO BAR</th>
                <th width="10%">COSTO</th>
                <th width="12%">PRECIO</th>
                <th>STOCK</th>
                <th width="10%">IMAGEN</th>
                <th>CATEGORIA</th>

            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td align="center">{{$item->name}}</td>
                <td align="center">{{$item->barcode}}</td>
                <td align="center">{{number_format($item->cost,2)}}</td>
                <td align="center">{{number_format($item->price,2)}}</td>
                <td align="center">{{$item->stock}}</td>
                <td align="center">{{$item->image}}</td>
                <td align="center">{{$item->category}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>

        </tfoot>
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