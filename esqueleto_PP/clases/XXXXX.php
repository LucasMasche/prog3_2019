<?php
class XXXXX
{
    public $ATR1;
    public $ATR2;
    public $ATR3;
    public $ATR4;

    function __construct($ATR1, $ATR2, $ATR3, $ATR4)
    {
        $this->ATR1 = $ATR1;
        $this->ATR2 = $ATR2;
        $this->ATR3 = $ATR3;
        $this->ATR4 = $ATR4;
    }

    public function RetornarJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
    
    public function Guardar($ruta)
    {
        $XXXXXs = self::Cargar($ruta);
        if($XXXXXs != null)
        {
            if(!self::XXXXXIsInListXXXXXs($XXXXXs, $this))
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
            $XXXXXs = array();
            while(!feof($arch))
            {
                $linea = fgets($arch);
                if($linea != "")
                {
                    $stdObj = json_decode($linea);
                    $XXXXX = new XXXXX($stdObj->ATR1, $stdObj->ATR2, $stdObj->ATR3, $stdObj->ATR4);
                    array_push($XXXXXs, $XXXXX);
                }
            }
            fclose($arch);
            if(count($XXXXXs) > 0)
                return $XXXXXs;
        }
        return null;
    }
    
    public static function GuardarTodo($XXXXXs, $ruta)
    {
        if(file_exists($ruta))
        {
            foreach ($XXXXXs as $YYYYY)
            {
                if(!$YYYYY->Guardar($ruta))
                    return false;
            }
            return true;
        }
        return false;
    }

    private static function XXXXXIsInListXXXXXs($XXXXXs, $XXXXX)
    {
        foreach ($XXXXXs as $YYYYY)
        {
            if($YYYYY->ATR1 == $XXXXX->ATR1)
                return true;
        }
        return false;
    }

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

    public function CargarImagen($files, $rutaCarpetaImagenes)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                $nombreDelArchivoImagen = $this->ATR1."_".strtolower($this->ATR2).$extension;
                $rutaCompletaImagen = $rutaCarpetaImagenes.$nombreDelArchivoImagen;
                return move_uploaded_file($files["tmp_name"], $rutaCompletaImagen);
            }
        }
        return false;
    }

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

    public function BorrarXXXXX($ruta)
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
                        unset($XXXXXs[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($XXXXXs, $ruta);
            }
        }
        return false;
    }
}
?>