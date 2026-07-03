@extends('layouts.app')

@section('content')
    <div style="background:#9ECFFF; padding:10px; border-radius:5px; margin-bottom:15px;">
        <h2 style="margin:0; font-weight:bold;">Venta - Ticket 1</h2>
        <form action="{{ route('venta.agregar') }}" method="POST" style="margin-top:10px; display:flex;">
            @csrf
            <input type="text" name="codigo" placeholder="Código del producto"
                   style="flex:1; padding:8px; border:1px solid #ccc; border-radius:4px;" required>
        </form>
    </div>

    <table style="width:100%; border-collapse:collapse; margin-bottom:15px;">
        <thead style="background:#ddd;">
            <tr>
                <th style="border:1px solid #707070; padding:6px;">Código de barras</th>
                <th style="border:1px solid #707070; padding:6px;">Descripción del producto</th>
                <th style="border:1px solid #707070; padding:6px;">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $i => $p)
            <tr>
                <td style="border:1px solid #F1F1F1; padding:6px;">{{ $p['Codigo'] }}</td>
                <td style="border:1px solid #F1F1F1; padding:6px;">{{ $p['Descripcion'] }}</td>
                <td style="border:1px solid #F1F1F1; padding:6px;">${{ number_format($p['Precio'],2) }}</td>
            @endforeach
        </tbody>
    </table>
    <div style="text-align:right; margin-bottom:20px;">
        <button type="button" onclick="document.getElementById('modalEliminar').style.display='block';" style="background:#F7F7F7; color:#000000; border:none; border-radius:6px; padding:8px 16px; cursor:pointer;">F6 - Eliminar producto</button>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <p><strong>Cambio:</strong> $0.00</p>
        </div>
        <div style="display:flex; align-items:center;">
                    <button type="button" onclick="document.getElementById('modalCobrar').style.display='block';" style="background:#F7F7F7; color:#000000; border:none; border-radius:6px; padding:8px 16px; cursor:pointer;">F12 - Cobrar</button>
            <div style="font-size:28px; font-weight:bold; color:#0077B6;">
                ${{ number_format($total,2) }}
            </div>
        </div>
    </div>
            <div style="text-align:right; margin-bottom:30px;">
                <button type="button" onclick="abrirVentasDia()" style="background:#F7F7F7; color:#000000; border:none; border-radius:6px; padding:8px 16px; cursor:pointer;">F5 - Ventas del día y devoluciones</button>
            </div>

<div id="modalEliminar" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6);">
    <div style="background:#fff; width:400px; margin:100px auto; padding:20px; border-radius:8px; text-align:center;">
        <form action="{{ route('venta.eliminar.codigo') }}" method="POST">
            @csrf
            <label for="codigo">Código del producto:</label>
            <input type="text" name="codigo" id="codigo" required
                   style="width:100%; padding:8px; margin:10px 0; border:1px solid #ccc; border-radius:6px;">
                   <div style="margin-top:15px;">
                        <button type="submit" style="background:#F7F7F7; color:#000000; border:none; border-radius:6px; padding:8px 16px; cursor:pointer;">Aceptar</button>
                   </div>
         </form>
    </div>
</div>

<div id="modalCobrar" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6);">
    <div style="background:#fff; width:700px; margin:50px auto; padding:20px; border-radius:8px; display:flex; box-shadow:0 4px 12px rgba(0,0,0,0.3);">
        
        <div style="flex:3; padding:20px; text-align:center; border-right:1px solid #ddd;">
            <h2 style="margin:0; font-size:22px;">Total a cobrar:</h2>
            <div style="font-size:40px; font-weight:bold; margin:15px 0; color:#000;">
                ${{ number_format($total,2) }}
            </div>

            <h3 style="margin:15px 0 10px;">Tipo de pago:</h3>
            <div style="margin-bottom:20px;">
                <button type="button" onclick="mostrarEfectivo()" style="padding:10px 18px; margin:5px; border-radius:6px; border:1px solid #ccc; cursor:pointer;">F3 - Efectivo</button>
                <button type="button" onclick="pagarTarjeta()" style="padding:10px 18px; margin:5px; border-radius:6px; border:1px solid #ccc; cursor:pointer;">F4 - Tarjeta</button>
            </div>

            <div id="efectivoDiv" style="display:none; margin-top:15px;">
                <label for="montoEfectivo" style="display:block; margin-bottom:5px;">Pagó con:</label>
                <input type="number" id="montoEfectivo" style="width:150px; padding:6px; margin-bottom:10px;" min="{{ $total }}">
                <p id="cambioTexto" style="margin-top:5px; font-size:18px; font-weight:bold; color:#333;"></p>
            </div>
        </div>

        <div style="flex:1; padding:20px; display:flex; flex-direction:column; justify-content:space-between; align-items:center;">
            <form id="formCobrar" action="{{ route('venta.ticket') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="monto" id="montoInput">
                <input type="hidden" name="operador_nombre" id="operadorNombreInput">
                <input type="hidden" name="operador_id" id="operadorIDInput">
            </form>
            <button type="button" onclick="finalizarCobro();" style="background:#f7f7f7; border:1px solid #ccc; border-radius:6px; padding:12px 20px; margin-bottom:15px; width:100%; cursor:pointer;">F1 - Cobrar e imprimir</button>


            <button type="button" onclick="cerrarModal('modalCobrar')" style="background:#FFB3B3; border:1px solid #e66; border-radius:6px; padding:12px 20px; margin-bottom:15px; width:100%; cursor:pointer;">ESC - Cancelar</button>
            <script>function cerrarModal(id) {document.getElementById(id).style.display = 'none';}</script>
            <div style="font-size:16px; margin-top:auto;">
                <strong>Total de artículos:</strong> {{ count($productos) }}
            </div>
        </div>
    </div>
</div>

<script>
function mostrarEfectivo() {
    document.getElementById('efectivoDiv').style.display = 'block';
}

function calcularCambio() {
    let total = {{ $total }};
    let recibido = parseFloat(document.getElementById('montoEfectivo').value);
    if (isNaN(recibido) || recibido < total) {
        alert("El monto recibido es insuficiente");
        return;
    }
    let cambio = recibido - total;
    document.getElementById('cambioTexto').innerText = "Cambio: $" + cambio.toFixed(2);
}

function pagarTarjeta() {
    let total = {{ $total }};
    document.getElementById('montoInput').value = total;
    document.getElementById('formCobrar').submit();
    document.getElementById('operadorNombreInput').value = localStorage.getItem("operadorNombre") || "Juan";
    document.getElementById('operadorIDInput').value = localStorage.getItem("operadorID") || "001";
    cerrarModal('modalCobrar');
    setTimeout(() => window.location.reload(), 1000);
}

function finalizarCobro() {
    let recibido = parseFloat(document.getElementById('montoEfectivo').value);
    let total = {{ $total }};
    if (isNaN(recibido) || recibido < total) {
        alert("El monto recibido es insuficiente");
        return;
    }

    let cambio = recibido - total;
    document.getElementById('cambioTexto').innerText = "Cambio: $" + cambio.toFixed(2);
    document.getElementById('montoInput').value = recibido;
    document.getElementById('formCobrar').submit();
    document.getElementById('operadorNombreInput').value = localStorage.getItem("operadorNombre") || "Juan";
    document.getElementById('operadorIDInput').value = localStorage.getItem("operadorID") || "001";

    cerrarModal('modalCobrar');
    setTimeout(() => window.location.reload(), 1000);
}
</script>

<div style="margin:20px 0;">
    <h3>Seleccionar producto:</h3>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap:10px;">
        @foreach($productosDB as $producto)
            <form action="{{ route('venta.agregar') }}" method="POST">
                @csrf
                <input type="hidden" name="codigo" value="{{ $producto->Codigo_barra }}">
                <button type="submit" 
                        style="background:#E9F5FF; border:1px solid #ccc; border-radius:8px; padding:10px; cursor:pointer; width:100%;">
                    <strong>{{ $producto->Nombre_pr }}</strong><br>
                    ${{ number_format($producto->Precio,2) }}
                </button>
            </form>
        @endforeach
    </div>
</div>


<div id="modalVentasDia" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:999;">
    <div style="background:#fff; width:90%; max-width:1200px; margin:50px auto; padding:20px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <h2 style="margin:0;">Ventas del día y devoluciones</h2>
            <button onclick="cerrarModal('modalVentasDia')" 
                style="background:#FFB3B3; border:none; border-radius:6px; padding:6px 12px; cursor:pointer;">Cerrar ✖</button>
        </div>

        <input type="text" id="buscar" placeholder="Buscar producto..." 
               style="width:100%; padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:10px;">

        <div id="resultadoBusqueda" style="border:1px solid #ddd; border-radius:8px; overflow:auto;">
            Cargando ventas...
        </div>
    </div>
</div>

<script>
function abrirVentasDia() {
    document.getElementById('modalVentasDia').style.display = 'block';
    $('#resultadoBusqueda').html('Cargando ventas...');
    $.ajax({
        url: '{{ route("venta.ventasDelDia") }}',
        type: 'GET',
        success: function(data) {
            if (data.length == 0) {
                $('#resultadoBusqueda').html('<p>No hay ventas hoy.</p>');
                return;
            }
            let html = '<table style="width:100%; border-collapse: collapse;"><thead><tr><th>ID</th><th>Operador</th><th>Total</th><th>Fecha</th></tr></thead><tbody>';
            data.forEach(venta => {
                let total = venta.detalles.reduce((acc, d) => acc + (d.Precio_unitario * d.Cantidad), 0).toFixed(2);
                html += `<tr style="border-bottom:1px solid #ddd;">
                            <td>${venta.id_venta}</td>
                            <td>${venta.operador ? venta.operador.Nombre_operador : ''}</td>
                            <td>$${total}</td>
                            <td>${venta.fecha}</td>
                         </tr>`;
            });
            html += '</tbody></table>';
            $('#resultadoBusqueda').html(html);
        },
        error: function() {
            $('#resultadoBusqueda').html('<p>Error al cargar las ventas.</p>');
        }
    });
}

$('#buscar').on('keyup', function () {
    var valor = $(this).val();
    $.ajax({
        url: '{{ route("venta.ventasDelDia") }}',
        type: 'GET',
        data: { q: valor },
        success: function (data) {
            if (data.length == 0) {
                $('#resultadoBusqueda').html('<p>No se encontraron resultados.</p>');
                return;
            }
            let html = '<table style="width:100%; border-collapse: collapse;"><thead><tr><th>ID</th><th>Operador</th><th>Total</th><th>Fecha</th></tr></thead><tbody>';
            data.forEach(venta => {
                let total = venta.detalles.reduce((acc, d) => acc + (d.Precio_unitario * d.Cantidad), 0).toFixed(2);
                html += `<tr style="border-bottom:1px solid #ddd;">
                            <td>${venta.id_venta}</td>
                            <td>${venta.operador ? venta.operador.Nombre_operador : ''}</td>
                            <td>$${total}</td>
                            <td>${venta.fecha}</td>
                         </tr>`;
            });
            html += '</tbody></table>';
            $('#resultadoBusqueda').html(html);
        }
    });
});

</script>

@endsection