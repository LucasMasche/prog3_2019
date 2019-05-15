<?php
if(isset($_GET['sabor']) && isset($_GET['tipo']))
{
    $sabor = $_GET['sabor'];
    $tipo = $_GET['tipo'];
    $respuesta = Pizza::ExistePizzaPorSaborYTipo($RUTA_PIZZAS, $sabor, $tipo);
    if($respuesta)
    {
        echo "Si Hay.";
    }
    else
        echo "No existe pizza con sabor ".$sabor." y tipo ".$tipo.".";
}
else
{
    echo 'Error cargue "atributo" y "tipo".';
}
?>