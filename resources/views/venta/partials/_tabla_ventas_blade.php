<div style="display:flex; gap:20px; height:70vh;">
    <!-- PANEL IZQUIERDO -->
    <div style="flex:1; background:#F2F8FF; border-radius:8px; overflow:auto; padding:10px;">
        <h3 style="text-align:center; margin-bottom:10px;">Ventas del día</h3>

        @if($ventas->count() > 0)
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background:#0077B6; color:white;">
                    <tr>
                        <th style="padding:6px;">Folio</th>
                        <th style="padding:6px;">Hora</th>
                        <th style="padding:6px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr onclick="mostrarDetalleVenta({{ $venta->id_venta }})" 
                            style="cursor:pointer; border-bottom:1px solid #ddd;">
                            <td style="padding:6px;">{{ $venta->id_venta }}</td>
                            <td style="padding:6px;">{{ \Carbon\Carbon::parse($venta->created_at)->format('H:i') }}</td>
                            <td style="padding:6px;">${{ number_format($venta->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align:center; color:#666;">No hay ventas registradas hoy.</p>
        @endif

        <h3 style="text-align:center; margin:15px 0 10px;">Devoluciones</h3>
        @if($devoluciones->count() > 0)
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background:#023E8A; color:white;">
                    <tr>
                        <th style="padding:6px;">Código</th>
                        <th style="padding:6px;">Motivo</th>
                        <th style="padding:6px;">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devoluciones as $dev)
                        <tr onclick="mostrarDetalleDevolucion({{ $dev->id_devolucion }})" 
                            style="cursor:pointer; border-bottom:1px solid #ddd;">
                            <td style="padding:6px;">{{ $dev->Codigo }}</td>
                            <td style="padding:6px;">{{ $dev->Motivo }}</td>
                            <td style="padding:6px;">{{ \Carbon\Carbon::parse($dev->created_at)->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align:center; color:#666;">No hay devoluciones hoy.</p>
        @endif
    </div>

    <!-- PANEL DERECHO -->
    <div id="detalleVenta" style="flex:2; background:#fff; border-radius:8px; padding:15px; overflow:auto;">
        <h3 style="text-align:center; color:#0077B6;">Selecciona una venta o devolución</h3>
        <p style="text-align:center; color:#666;">Aquí se mostrará el detalle del ticket o producto.</p>
    </div>
</div>

<script>
function mostrarDetalleVenta(id) {
    $('#detalleVenta').html('<p style="text-align:center;">Cargando detalles...</p>');
    $.ajax({
        url: '/ventas/' + id,
        type: 'GET',
        success: function(data) {
            $('#detalleVenta').html(data);
        },
        error: function() {
            $('#detalleVenta').html('<p style="color:red;">Error al cargar los detalles.</p>');
        }
    });
}

function mostrarDetalleDevolucion(id) {
    $('#detalleVenta').html('<p style="text-align:center;">Cargando detalles de la devolución...</p>');
    $.ajax({
        url: '/devoluciones/' + id,
        type: 'GET',
        success: function(data) {
            $('#detalleVenta').html(data);
        },
        error: function() {
            $('#detalleVenta').html('<p style="color:red;">Error al cargar la devolución.</p>');
        }
    });
}
</script>
