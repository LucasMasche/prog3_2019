<?php
require_once 'clases/Pizza.php';
class Venta
{
    public $id;
    public $email;
    public $sabor;
    public $tipo;
    public $cantidad;

    function __construct($id, $email, $sabor, $tipo, $cantidad)
    {
        $this->id = $id;
        $this->email = $email;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public function RetornarJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
    
    public function Guardar($ruta)
    {
        $ventas = self::Cargar($ruta);
        if($ventas != null)
        {
            $maxId = self::TraerMayorId($ventas);
            $this->id = $maxId + 1;
            if(!self::VentaIsInListVentas($ventas, $this))
            {
                if(file_exists($ruta))
                {
                    $arch = fopen($ruta, "a");
                    return fwrite($arch, $this->RetornarJson().PHP_EOL);
                }
                $arch = fopen($ruta, "w");
                return fwrite($arch, $this->RetornarJson().PHP_EOL);
            }
        }
        else
        {
            if(file_exists($ruta))
            {
                $arch = fopen($ruta, "a");
                return fwrite($arch, $this->RetornarJson().PHP_EOL);
            }
            $arch = fopen($ruta, "w");
            return fwrite($arch, $this->RetornarJson().PHP_EOL);
        }
        return false;
    }

    public static function Cargar($ruta)
    {
        if(file_exists($ruta))
        {
            $arch = fopen($ruta, "r");
            $ventas = array();
            while(!feof($arch))
            {
                $linea = fgets($arch);
                if($linea != "")
                {
                    $stdObj = json_decode($linea);
                    $venta = new Venta($stdObj->id, $stdObj->email, $stdObj->sabor, $stdObj->tipo, $stdObj->cantidad);
                    array_push($ventas, $venta);
                }
            }
            fclose($arch);
            if(count($ventas) > 0)
                return $ventas;
        }
        return null;
    }

    public static function GuardarTodo($ventas, $ruta)
    {
        if(file_exists($ruta))
        {
            foreach ($ventas as $key => $pi)
            {
                if($key == 0)
                {
                    $arch = fopen($ruta, "w");
                    fwrite($arch, json_encode($ventas[0]).PHP_EOL);
                    fclose($arch);
                }
                else
                {
                    $arch = fopen($ruta, "a");
                    fwrite($arch, json_encode($ventas[$key]).PHP_EOL);
                    fclose($arch);
                }
            }
            return true;
        }
        return false;
    }

    private static function VentaIsInListVentas($ventas, $venta)
    {
        foreach ($ventas as $ve)
        {
            if($ve->id == $venta->id)
                return true;
        }
        return false;
    }
/*
    public static function TraerXXXXXPorAtributo($ruta, $atributo)
    {
        $XXXXXs = self::Cargar($ruta);
        if($XXXXXs != null)
        {
            $misXXXXXs = array();
            foreach ($XXXXXs as $YYYYY)
            {
                if(strtolower($atributo) == strtolower($YYYYY->ATR1) || 
                    strtolower($atributo) == strtolower($YYYYY->ATR2) || 
                    strtolower($atributo) == strtolower($YYYYY->ATR3))
                    array_push($misXXXXXs, $YYYYY);
            }
            if(count($misXXXXXs) > 0)
                return $misXXXXXs;
        }
        return null;
    }

    public static function XXXXXsToTable($XXXXXs, $rutaCarpetaImagenes)
    {
        $texto = "<table border='1'>";
        $texto .= "<thead bgcolor='lightgrey'>";
        $texto .= "<tr>";
        $texto .= "<th>ATR1</th>";
        $texto .= "<th>ATR2</th>";
        $texto .= "<th>ATR3</th>";
        $texto .= "<th>ATR4</th>";
        $texto .= "</tr>";
        $texto .= "</thead>";
        $texto .= "<tbody>";
        foreach ($XXXXXs as $XXXXX)
        {
            $texto .= "<tr>";
            $texto .= "<td>".$XXXXX->ATR1."</td>";
            $texto .= "<td>".$XXXXX->ATR2."</td>";
            $texto .= "<td>".$XXXXX->ATR3."</td>";
            $texto .= "<td><img src='".$rutaCarpetaImagenes.$XXXXX->ATR4."' height='120' width='120' /></td>";
            $texto .= "</tr>";
        }
        $texto .= "</tbody>";
        $texto .= "</table>";
        return $texto;
    }

    public static function TraerXXXXXPorATR1($ruta, $ATR1)
    {
        $XXXXXs = self::Cargar($ruta);
        if($XXXXXs != null)
        {
            foreach ($XXXXXs as $YYYYY)
            {
                if($YYYYY->ATR1 == $ATR1)
                    return $YYYYY;
            }
        }
        return null;
    }

    public function IsEqual($otroXXXXX)
    {
        return $this->ATR1 == $otroXXXXX->ATR1 && 
                    $this->ATR2 == $otroXXXXX->ATR2 &&
                    $this->ATR3 == $otroXXXXX->ATR3 &&
                    $this->ATR4 == $otroXXXXX->ATR4;
    }
*/
    public function CargarImagen($files, $rutaCarpetaImagenes)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $nombreDelArchivoImagen = strtolower($this->sabor)."_".date('Ymd').$extension;
                $rutaCompletaImagen = $rutaCarpetaImagenes.$nombreDelArchivoImagen;
                return move_uploaded_file($files["tmp_name"], $rutaCompletaImagen);
            }
        }
        return false;
    }
/*
    public function MoverImagenABackUp($rutaCarpetaImagenesBackUp, $rutaCarpetaImagenes, $rutaXXXXXs)
    {
        $XXXXX = self::TraerXXXXXPorATR1($rutaXXXXXs, $this->ATR1);
        if($XXXXX != null)
        {
            $rutaCompletaImagenAntigua = $rutaCarpetaImagenes.$XXXXX->IMG1;
            if(file_exists($rutaCompletaImagenAntigua))
            {
                $extension = ".".array_reverse(explode(".", $XXXXX->IMG1))[0];
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $rutaCompletaImagenBackUp = $directorioFotosBackUp.$this->ATR1."_".date('Ymd').$extension;
                return rename($rutaCompletaImagenAntigua, $rutaCompletaImagenBackUp);
            }
        }
        return false;
    }
*/
    public static function TraerExtensionImagen($files)
    {
        switch ($files["type"])
        {
            case 'image/jpeg':
                $extension = ".jpg";
                break;
            case 'image/png':
                $extension = ".png";
                break;
            default:
                return null;
                break;
        }
        return $extension;
    }
/*
    public function ModificarXXXXX($ruta)
    {
        $XXXXXs = self::Cargar($ruta);
        if($XXXXXs != null)
        {
            if(self::XXXXXIsInListXXXXXs($XXXXXs, $this))
            {
                foreach ($XXXXXs as $key => $YYYYY)
                {
                    if($YYYYY->ATR1 == $this->ATR1)
                    {
                        $XXXXXs[$key] = $this;
                        break;
                    }
                }
                return self::GuardarTodo($XXXXXs, $ruta);
            }
        }
        return false;
    }
*/
    public function BorrarVenta($ruta)
    {
        $ventas = self::Cargar($ruta);
        if($ventas != null)
        {
            if(self::VentaIsInListVentas($ventas, $this))
            {
                foreach ($ventas as $key => $ve)
                {
                    if($ve->ATR1 == $this->ATR1)
                    {
                        unset($ventas[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($XXXXXs, $ruta);
            }
        }
        return false;
    }

    public static function TraerMayorId($ventas)
    {
        $maxId = $ventas[0]->id;
        foreach ($ventas as $ve)
        {
            if($ve->id > $maxId)
                $maxId = $ve->id;
        }
        return $maxId;
    }
}
?>