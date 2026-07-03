<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body {
            font-family: monospace;
            font-size: 11px;
            width: 250px;
            margin: 0 auto;
            padding: 0;
            text-align: center;
            line-height: 1.2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0;
            font-size: 11px;
        }
        th, td {
            padding: 2px 3px;
            text-align: left;
            font-weight: normal;
        }
        th {
            border-bottom: 1px dashed #000;
        }
        .right { text-align: right; }
        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <div>Tienda {{ $tienda['id_tienda'] ?? '' }}</div>
    <div>{{ $tienda['Direccion'] ?? '' }}</div>
    <div>TEL: {{ $tienda['Telefono1'] ?? '' }}</div>
    <div>TDA {{ $venta['no_registro'] ?? '' }} OP {{ $ticket['id_ticket'] ?? '' }} TE {{ $operador['id_operador'] ?? '' }}</div>

    {{-- Productos --}}
    <table>
        <thead>
            
            <tr>
                <th>CÓDIGO</th>
                <th>PRODUCTO</th>
                <th>CANT.</th>
                <th>IMPORTE</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $p)
            <tr>
                <td>{{ $p['Codigo'] }}</td>
                <td>{{ $p['Descripcion'] }}</td>
                <td>{{ $p['Cantidad'] ?? 1 }}</td>
                <td>${{ number_format(($p['Cantidad'] ?? 1) * ($p['PrecioUnitario'] ?? $p['Precio']), 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="center">Sin productos</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Promociones --}}
    @if(!empty($promociones))
        <div>PROMOCIONES:</div>
        @foreach($promociones as $promo)
            <div>- {{ $promo['Descripcion'] ?? 'PROMO' }} ${{ number_format($promo['Precio'], 2) }}</div>
        @endforeach
    @endif

    {{-- Totales --}}
    <table>
        <tr><td>TOTAL:</td><td class="right">${{ number_format($ticket['Total'] ?? $total, 2) }}</td></tr>
        <tr><td>EFECTIVO:</td><td class="right">${{ number_format($pago['Monto'] ?? 0, 2) }}</td></tr>
        <tr><td>CAMBIO:</td><td class="right">${{ number_format(max(0, ($pago['Monto'] ?? 0) - ($ticket['Total'] ?? $total)), 2) }}</td></tr>
    </table>

    <div class="line"></div>

    {{-- Cliente y beneficios --}}
    <div>BENEFICIOS</div>
    <div class="line"></div>
    <div>BENEFICIOS DISPONIBLES {{ $cliente['No_beneficios'] ?? 0 }}</div>
    <div>CLIENTE: {{ $cliente['Nombre_cl'] ?? '' }}</div>
    <div>{{ $tienda['P_Web1'] ?? '' }}</div>

    <div class="line"></div>
    <div class="line"></div>

    {{-- Garantía --}}
    <div>GARANTÍA:</div>
    @foreach($productos as $p)
        <div>{{ $p['Garantia'] ?? '' }}</div>
    @endforeach

    {{-- Forma de pago --}}
    <div>FORMA DE PAGO: {{ $formaPago['Descripcion_pago'] ?? 'EFECTIVO' }}</div>
    {{-- Sitios web --}}
    <div>{{ $tienda['P_Web2'] ?? '' }}</div>
    <div>TEL: {{ $tienda['Telefono2'] ?? '' }}</div>
    <div class="line"></div>
    <div>{{ $tienda['P_Web3'] ?? '' }}</div>

    <div>DESCARGA LA APP....</div>
    <div>FECHA: {{ $ticket['Fecha'] ?? now()->format('d/m/Y') }} HORA: {{ $ticket['Hora'] ?? now()->format('H:i') }}</div>
</body>
</html>
