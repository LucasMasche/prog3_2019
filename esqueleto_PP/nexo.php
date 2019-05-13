<?php
require_once 'clases/XXXXX.php';
if(isset($_REQUEST['caso']))
{
    $RUTA_XXXXXs = "archivos/XXXXX.txt";
    $RUTA_CARPETA_IMAGENES = "imagenes/";
    $RUTA_CARPETA_IMAGENES_BACKUP = "imagenesBackUp/";
    $caso = strtolower($_REQUEST['caso']);
    $verboHttp = strtoupper($_SERVER["REQUEST_METHOD"]);
    $caso .= "-".$verboHttp;
    switch ($caso)
    {
        case 'cargarXXXXX-POST':
            if(isset($_POST['ATR1']) && isset($_POST['ATR2']) && isset($_POST['ATR3']) && isset($_POST['ATR4']) && isset($_FILES['IMG1']))
            {
                $ATR1 = $_POST['ATR1'];
                $ATR2 = $_POST['ATR2'];
                $ATR3 = $_POST['ATR3'];
                $ATR4 = $_POST['ATR4'];
                $IMG1 = $_FILES['IMG1'];
                $XXXXX = new XXXXX($ATR1, $ATR2, $ATR3, $ATR4);
                if($XXXXX->Guardar($RUTA_XXXXXs))
                {
                    if($XXXXX->CargarImagen($IMG1, $RUTA_CARPETA_IMAGENES))
                        echo "Exito.";
                    else
                    {
                        $XXXXX->BorrarXXXXX($RUTA_XXXXXs);
                        echo "Fallo.";
                    }
                }
                else
                    echo "Fallo.";
            }
            else
                echo 'Error cargue "ATR1", "ATR2", "ATR3" y "ATR4".';
            break;
        case 'traerXXXXX-GET':
            if(isset($_GET['ATR1']))
            {
                $ATR1 = $_GET['ATR1'];
                $XXXXX = XXXXX::TraerXXXXXPorATR1($RUTA_XXXXXs, $ATR1);
                if($XXXXX != null)
                {
                    $XXXXXs = array();
                    array_push($XXXXXs, $XXXXX);
                    echo XXXXX::XXXXXsToTable($XXXXXs, $RUTA_CARPETA_IMAGENES);
                }
                else
                    echo "No existe ".$ATR1;
            }
            else
            {
                echo 'Error cargue "ATR1".';
            }
            break;
        case 'traertodosXXXXX-GET':
            $XXXXXs = XXXXX::Cargar($RUTA_XXXXXs);
            if($XXXXXs != null)
                echo XXXXX::XXXXXsToTable($XXXXXs, $RUTA_CARPETA_IMAGENES);
            else
                echo "No hay registros cargados.";
            break;
        case 'modificarXXXXX-POST':
            if(isset($_POST['ATR1']) && isset($_POST['ATR2']) && isset($_POST['ATR3']) && isset($_POST['ATR4']) && isset($_FILES['IMG1']))
            {
                $ATR1 = $_POST['ATR1'];
                $ATR2 = $_POST['ATR2'];
                $ATR3 = $_POST['ATR3'];
                $ATR4 = $_POST['ATR4'];
                $IMG1 = $_FILES['IMG1'];
                $XXXXX = new XXXXX($ATR1, $ATR2, $ATR3, $ATR4, $ATR1."_".strtolower($ATR2).$extension);
                if($XXXXX->ModificarXXXXX($RUTA_XXXXXs))
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
                    echo "Fallo.";
            }
            else
                echo 'Error cargue "ATR1", "ATR2", "ATR3", "ATR4" y "IMG1".';
            break;
        case 'borrarXXXXX-POST':
            if(isset($_POST['ATR1']))
            {
                $ATR1 = $_POST['ATR1'];
                $XXXXX = XXXXX::TraerXXXXXPorATR1($RUTA_XXXXXs, $ATR1);
                if($XXXXX != null)
                    echo $XXXXX->BorrarXXXXX($RUTA_XXXXXs) ? "Exito" : "Fallo";
                else
                    echo "No existe ".$ATR1;
            }
            else
            {
                echo 'Error cargue "ATR1".';
            }
            break;
            if(isset($_POST['ATR1']))
            {
                $ATR1 = $_POST['ATR1'];

                if($XXXXX->ModificarXXXXX($RUTA_XXXXXs))
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
                    echo "Fallo.";
            }
            else
                echo 'Error cargue "ATR1", "ATR2", "ATR3", "ATR4" y "IMG1".';
            break;
        default:
            break;
    }
}
else
{
    echo "Ingrese un caso.";
}
?>