@if(isset($venta))
    <h3 style="text-align:center;">Ticket #{{ $venta->id_venta }}</h3>
    <p><strong>Operador:</strong> {{ $venta->operador->Nombre_op ?? 'N/A' }}</p>
    <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>

    <table style="width:100%; border-collapse:collapse;">
        <thead style="background:#0077B6; color:white;">
            <tr>
                <th style="padding:6px;">Código</th>
                <th style="padding:6px;">Descripción</th>
                <th style="padding:6px;">Precio</th>
                <th style="padding:6px;">Cant.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $d)
                <tr style="border-bottom:1px solid #ddd;">
                    <td style="padding:6px;">{{ $d->codigo }}</td>
                    <td style="padding:6px;">{{ $d->descripcion }}</td>
                    <td style="padding:6px;">${{ number_format($d->precio, 2) }}</td>
                    <td style="padding:6px;">{{ $d->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align:right; font-weight:bold; font-size:18px; margin-top:10px;">
        Total: ${{ number_format($venta->total, 2) }}
    </p>
@else
    <p style="text-align:center; color:#999;">No se encontró la venta.</p>
@endif
