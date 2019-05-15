<?php
if(isset($_GET['mostrar']))
{
    $mostrar = $_GET['mostrar'];
    $pizzas = Pizza::Cargar($RUTA_PIZZAS);
    if($pizzas != null)
    {
        switch ($mostrar)
        {
            case 'cargadas':
                echo Pizza::PizzasToTable($pizzas, $RUTA_CARPETA_IMAGENES);
                break;
            case 'borradas':
                echo Pizza::PizzasToTable($pizzas, $RUTA_CARPETA_IMAGENES_BACKUP);
                break;
            default:
                break;
        }
    }
    else
        echo "Error no hay pizzas cargadas.";
}
else
{
    echo 'Error cargue en "mostrar": "cargadas" o "borradas".';
}
?>