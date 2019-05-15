<?php
//Funciona con "x-www-form-urlencoded"
parse_str(file_get_contents("php://input"), $params);
if(isset($params["id"]))
{
    $id = $params['id'];
    $pizza = Pizza::TraerPizzaPorId($RUTA_PIZZAS, $id);
    if($pizza != null)
        if($pizza->BorrarPizza($RUTA_PIZZAS))
        {
            if($XXXXX->MoverImagenABackUp($RUTA_CARPETA_IMAGENES_BACKUP, $RUTA_CARPETA_IMAGENES, $RUTA_XXXXXs))
            {
                if($XXXXX->CargarImagen($IMG1, $RUTA_CARPETA_IMAGENES))
                    echo "Exito.";
                echo "La imagen no se pudo subir.";
            }
            else
                echo "No se pudo hacer el backUp de la imagen.";
        }
        else
            echo "Fallo";
    else
        echo "No existe ".$id;
}
else
{
    echo 'Error cargue "id".';
}
?>