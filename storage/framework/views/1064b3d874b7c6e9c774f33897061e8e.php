<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        h2, h3 { margin: 5px 0; text-align: center; }
    </style>
</head>
<body>
    <h2><?php echo e($tienda->Nombre); ?></h2>
    <p style="text-align:center;">
        <?php echo e($tienda->Direccion); ?> <br>
        Tel: <?php echo e($tienda->Telefono1); ?> <?php echo e($tienda->Telefono2); ?>

    </p>

    <p><strong>Operador:</strong> <?php echo e($operador->Nombre_op); ?></p>
    <p><strong>Fecha:</strong> <?php echo e(date('d/m/Y')); ?> - <strong>Hora:</strong> <?php echo e(date('H:i')); ?></p>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($p['Codigo']); ?></td>
                <td><?php echo e($p['Descripcion']); ?></td>
                <td>$<?php echo e(number_format($p['Precio'],2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <h3>Total: $<?php echo e(number_format($total,2)); ?></h3>
</body>
</html><?php /**PATH C:\Users\mizus\OneDrive\Escritorio\Ticket\resources\views/pdf/ticket.blade.php ENDPATH**/ ?>