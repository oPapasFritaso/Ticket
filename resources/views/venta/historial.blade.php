@extends('layouts.app')

@section('content')

<div class="container">
<h4 class="mb-3">Historial de Ventas</h4>

<input type="text" class="form-control mb-3" placeholder="Buscar por Folio o Nombre de Operador...">

@if ($tickets->isEmpty())
    <p class="text-center">No hay tickets de venta registrados aún.</p>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Folio Ticket</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Operador</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id_ticket }}</td>
                        <td>{{ $ticket->Fecha }}</td>
                        <td>{{ $ticket->Hora ? \Carbon\Carbon::parse($ticket->Hora)->format('h:i:s a') : 'N/A' }}</td>
                        <td>{{ $ticket->operador->Nombre_operador ?? 'N/A' }}</td>
                        <td>${{ number_format($ticket->Total, 2) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm"
                                    onclick="mostrarDetallePagina({{ $ticket->id_ticket }})">
                                Ver Detalle
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

</div>

{{-- Modal para ver detalle de ticket en esta página (necesitas Bootstrap) --}}

<div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Detalle de Ticket #<span id="ticket-id"></span></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body" id="detalle-ticket-body">
Cargando...
</div>
</div>
</div>
</div>

<script>
function mostrarDetallePagina(idTicket) {
document.getElementById('ticket-id').textContent = idTicket;
document.getElementById('detalle-ticket-body').innerHTML = 'Cargando...';

    fetch(`/historial/${idTicket}`)
        .then(res =&gt; res.json())
        .then(data =&gt; {
            let html = `
                &lt;p&gt;&lt;strong&gt;Operador:&lt;/strong&gt; ${data.ticket.operador.Nombre_operador}&lt;/p&gt;
                &lt;p&gt;&lt;strong&gt;Cliente:&lt;/strong&gt; ${data.ticket.cliente ? data.ticket.cliente.Nombre_cl : &#39;Público General&#39;}&lt;/p&gt;
                &lt;p&gt;&lt;strong&gt;Fecha/Hora:&lt;/strong&gt; ${data.ticket.Fecha} ${data.ticket.Hora}&lt;/p&gt;
                &lt;hr&gt;
                &lt;h4&gt;Productos Vendidos&lt;/h4&gt;
                &lt;table class=&quot;table table-striped&quot;&gt;
                    &lt;thead&gt;
                        &lt;tr&gt;
                            &lt;th&gt;Producto&lt;/th&gt;
                            &lt;th class=&quot;text-end&quot;&gt;Cantidad&lt;/th&gt;
                            &lt;th class=&quot;text-end&quot;&gt;Precio U.&lt;/th&gt;
                            &lt;th class=&quot;text-end&quot;&gt;Subtotal&lt;/th&gt;
                        &lt;/tr&gt;
                    &lt;/thead&gt;
                    &lt;tbody&gt;
            `;
            data.detalles.forEach(detalle =&gt; {
                const subtotal = detalle.Precio_unitario * detalle.Cantidad;
                html += `
                    &lt;tr&gt;
                        &lt;td&gt;${detalle.producto ? detalle.producto.Nombre_pr : &#39;N/A&#39;}&lt;/td&gt;
                        &lt;td class=&quot;text-end&quot;&gt;${detalle.Cantidad}&lt;/td&gt;
                        &lt;td class=&quot;text-end&quot;&gt;$${parseFloat(detalle.Precio_unitario).toFixed(2)}&lt;/td&gt;
                        &lt;td class=&quot;text-end&quot;&gt;$${subtotal.toFixed(2)}&lt;/td&gt;
                    &lt;/tr&gt;
                `;
            });
            
            html += `
                    &lt;/tbody&gt;
                &lt;/table&gt;
                &lt;h5 class=&quot;text-end mt-3&quot;&gt;Total del Ticket: $${parseFloat(data.ticket.Total).toFixed(2)}&lt;/h5&gt;
            `;

            document.getElementById(&#39;detalle-ticket-body&#39;).innerHTML = html;
            new bootstrap.Modal(document.getElementById(&#39;detalleModal&#39;)).show();
        })
        .catch(error =&gt; {
            document.getElementById(&#39;detalle-ticket-body&#39;).innerHTML = &#39;&lt;p class=&quot;text-danger&quot;&gt;Error al cargar los detalles.&lt;/p&gt;&#39;;
            console.error(&#39;Error fetching detail:&#39;, error);
        });
}

</script>

@endsection