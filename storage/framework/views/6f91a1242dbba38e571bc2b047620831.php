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

    
    <div>Tienda <?php echo e($tienda['id_tienda'] ?? ''); ?></div>
    <div><?php echo e($tienda['Direccion'] ?? ''); ?></div>
    <div>TEL: <?php echo e($tienda['Telefono1'] ?? ''); ?></div>
    <div>TDA <?php echo e($venta['no_registro'] ?? ''); ?> OP <?php echo e($ticket['id_ticket'] ?? ''); ?> TE <?php echo e($operador['id_operador'] ?? ''); ?></div>

    
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
            <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($p['Codigo']); ?></td>
                <td><?php echo e($p['Descripcion']); ?></td>
                <td><?php echo e($p['Cantidad'] ?? 1); ?></td>
                <td>$<?php echo e(number_format(($p['Cantidad'] ?? 1) * ($p['PrecioUnitario'] ?? $p['Precio']), 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="center">Sin productos</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    
    <?php if(!empty($promociones)): ?>
        <div>PROMOCIONES:</div>
        <?php $__currentLoopData = $promociones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>- <?php echo e($promo['Descripcion'] ?? 'PROMO'); ?> $<?php echo e(number_format($promo['Precio'], 2)); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    
    <table>
        <tr><td>TOTAL:</td><td class="right">$<?php echo e(number_format($ticket['Total'] ?? $total, 2)); ?></td></tr>
        <tr><td>EFECTIVO:</td><td class="right">$<?php echo e(number_format($pago['Monto'] ?? 0, 2)); ?></td></tr>
        <tr><td>CAMBIO:</td><td class="right">$<?php echo e(number_format(max(0, ($pago['Monto'] ?? 0) - ($ticket['Total'] ?? $total)), 2)); ?></td></tr>
    </table>

    <div class="line"></div>

    
    <div>BENEFICIOS</div>
    <div class="line"></div>
    <div>BENEFICIOS DISPONIBLES <?php echo e($cliente['No_beneficios'] ?? 0); ?></div>
    <div>CLIENTE: <?php echo e($cliente['Nombre_cl'] ?? ''); ?></div>
    <div><?php echo e($tienda['P_Web1'] ?? ''); ?></div>

    <div class="line"></div>
    <div class="line"></div>

    
    <div>GARANTÍA:</div>
    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div><?php echo e($p['Garantia'] ?? ''); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div>FORMA DE PAGO: <?php echo e($formaPago['Descripcion_pago'] ?? 'EFECTIVO'); ?></div>
    
    <div><?php echo e($tienda['P_Web2'] ?? ''); ?></div>
    <div>TEL: <?php echo e($tienda['Telefono2'] ?? ''); ?></div>
    <div class="line"></div>
    <div><?php echo e($tienda['P_Web3'] ?? ''); ?></div>

    <div>DESCARGA LA APP....</div>
    <div>FECHA: <?php echo e($ticket['Fecha'] ?? now()->format('d/m/Y')); ?> HORA: <?php echo e($ticket['Hora'] ?? now()->format('H:i')); ?></div>
</body>
</html>
<?php /**PATH C:\Users\mizus\OneDrive\Escritorio\Ticket\resources\views/venta/ticket.blade.php ENDPATH**/ ?>