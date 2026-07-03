<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TIENDA1</title>
    <style>
        body {
            font-family: sans-serif;
            background: #fff;
            color: #000;
            margin: 0;
        }

        header {
            background: #A19EFF;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .operador-box {
            background: #d6e3ff9d;
            color: #000;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            min-width: 220px;
        }

        .operador-box p {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-operador {
            display: block;
            width: 100%;
            margin-top: 5px;
            background: #F5F8FF;
            color: black;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-operador:hover {
            background: #F5F8FF;
        }

        main {
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>TIENDA1</h1>

        <div class="operador-box">
            <p>Operador:</p>
            <form action="#" method="GET">
                <button type="button" id="operadorBtn" class="btn-operador">Cambiar: Juan</button>
            </form>
        </div>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <div id="modalOperador" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:999;">
        <div style="background:#fff; width:400px; padding:20px; border-radius:8px; text-align:center; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); box-shadow:0 4px 12px rgba(0,0,0,0.3);"><h3 style="margin-bottom:15px;">Cambiar Operador</h3>
        <label for="nombreOperador">Nombre del operador:</label>
        <input type="text" id="nombreOperador" required style="width:100%; padding:8px; margin:10px 0; border:1px solid #ccc; border-radius:6px;">
        <label for="idOperador">ID del operador:</label>
        <input type="text" id="idOperador" required style="width:100%; padding:8px; margin:10px 0; border:1px solid #ccc; border-radius:6px;">
        <div style="margin-top:15px;"> <button id="btnAceptarOperador" style="background:#F7F7F7; color:#000000; border:none; border-radius:6px; padding:8px 16px; cursor:pointer;">Aceptar</button></div>
    </div>
</div>

<script>
    const operadorBtn = document.getElementById("operadorBtn");
    const modal = document.getElementById("modalOperador");
    const btnAceptar = document.getElementById("btnAceptarOperador");

    operadorBtn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    btnAceptar.addEventListener("click", () => {
        const nombre = document.getElementById("nombreOperador").value.trim();
        const id = document.getElementById("idOperador").value.trim();

        if (!nombre || !id) return;

        operadorBtn.textContent = "Cambiar: " + nombre;
        console.log("Operador cambiado:", nombre, "ID:", id);
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
</script>
</body>
</html><?php /**PATH C:\Users\mizus\OneDrive\Escritorio\Ticket\resources\views/layouts/app.blade.php ENDPATH**/ ?>