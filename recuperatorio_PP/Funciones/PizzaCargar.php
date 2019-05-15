<?php
if(isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_FILES['imagen']))
{
    $sabor = $_POST['sabor'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];
    $imagen = $_FILES['imagen'];
    if($tipo == "molde" || $tipo == "piedra")
    {
        if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial")
        {
            //ID AUTOINCREMENTAL
            $pizza = new Pizza(1, $sabor, $precio, $tipo, $cantidad);
            if($pizza->Guardar($RUTA_PIZZAS))
            {
                if($pizza->CargarImagen($imagen, $RUTA_CARPETA_IMAGENES))
                    echo "Exito.";
                else
                {
                    $pizza->BorrarPizza($RUTA_PIZZAS);
                    echo "Fallo.";
                }
            }
            else
                echo "Fallo.";
        }
        else
            echo 'Error cargue "sabor" como "muzza", "jamon" o "especial".';
    }
    else
        echo 'Error cargue "tipo" como "molde" o "piedra".';
}
else
    echo 'Error cargue "id", "sabor", "precio", "tipo", "cantidad" y "imagen".';
?>