<?php
if(isset($_GET['sabor']))
{
    $sabor = $_GET['sabor'];
    $pizzas = Pizza::TraerPizzasPorsabor($RUTA_PIZZAS, $sabor);
    if($pizzas != null)
    {
        echo Pizza::PizzasToTable($pizzas, $RUTA_CARPETA_IMAGENES);
    }
    else
        echo "No existe ".$sabor;
}
else
{
    echo 'Error cargue "sabor".';
}
?>