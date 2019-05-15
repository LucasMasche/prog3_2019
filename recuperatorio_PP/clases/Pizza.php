<?php
class Pizza
{
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;

    function __construct($id, $sabor, $precio, $tipo, $cantidad)
    {
        $this->id = $id;
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public function RetornarJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
    
    public function Guardar($ruta)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            $maxId = self::TraerMayorId($pizzas);
            $this->id = $maxId + 1;
            if(!self::PizzaIsInListPizzas($pizzas, $this))
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
            $pizzas = array();
            while(!feof($arch))
            {
                $linea = fgets($arch);
                if($linea != "")
                {
                    $stdObj = json_decode($linea);
                    $pizza = new Pizza($stdObj->id, $stdObj->sabor, $stdObj->precio, $stdObj->tipo, $stdObj->cantidad);
                    array_push($pizzas, $pizza);
                }
            }
            fclose($arch);
            if(count($pizzas) > 0)
                return $pizzas;
        }
        return null;
    }

    public static function GuardarTodo($pizzas, $ruta)
    {
        if(file_exists($ruta))
        {
            foreach ($pizzas as $key => $pi)
            {
                if($key == 0)
                {
                    $arch = fopen($ruta, "w");
                    fwrite($arch, json_encode($pizzas[0]).PHP_EOL);
                    fclose($arch);
                }
                else
                {
                    $arch = fopen($ruta, "a");
                    fwrite($arch, json_encode($pizzas[$key]).PHP_EOL);
                    fclose($arch);
                }
            }
            return true;
        }
        return false;
    }

    private static function PizzaIsInListPizzas($pizzas, $pizza)
    {
        foreach ($pizzas as $pi)
        {
            if($pi->id == $pizza->id)
                return true;
        }
        return false;
    }

    public static function ExistePizzaPorSaborYTipo($ruta, $sabor, $tipo)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            foreach ($pizzas as $pi)
            {
                if(strtolower($sabor) == strtolower($pi->sabor) &&
                    strtolower($tipo) == strtolower($pi->tipo))
                    return true;
            }
        }
        return false;
    }

    public static function PizzasToTable($pizzas, $rutaCarpetaImagenes)
    {
        $texto = "<table border='1'>";
        $texto .= "<thead bgcolor='lightgrey'>";
        $texto .= "<tr>";
        $texto .= "<th>Sabor</th>";
        $texto .= "<th>Precio</th>";
        $texto .= "<th>Tipo</th>";
        $texto .= "<th>Cantidad</th>";
        $texto .= "<th>Imagen</th>";
        $texto .= "</tr>";
        $texto .= "</thead>";
        $texto .= "<tbody>";
        foreach ($pizzas as $pizza)
        {
            $texto .= "<tr>";
            $texto .= "<td>".$pizza->sabor."</td>";
            $texto .= "<td>".$pizza->precio."</td>";
            $texto .= "<td>".$pizza->tipo."</td>";
            $texto .= "<td>".$pizza->cantidad."</td>";
            $texto .= "<td><img src='".$rutaCarpetaImagenes.$pizza->id."_".$pizza->sabor.".png' height='120' width='120' /></td>";
            $texto .= "</tr>";
        }
        $texto .= "</tbody>";
        $texto .= "</table>";
        return $texto;
    }

    public static function TraerPizzaPorId($ruta, $id)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            foreach ($pizzas as $pi)
            {
                if($pi->id == $id)
                    return $pi;
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
                $nombreDelArchivoImagen = $this->id."_".strtolower($this->sabor).$extension;
                $rutaCompletaImagen = $rutaCarpetaImagenes.$nombreDelArchivoImagen;
                return move_uploaded_file($files["tmp_name"], $rutaCompletaImagen);
            }
        }
        return false;
    }
    
    public static function TraerPizzasPorsabor($ruta, $sabor)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            $misPizzas = array();
            foreach ($pizzas as $pi)
            {
                if($pi->sabor == $sabor)
                    array_push($misPizzas, $pi);
            }
            if(count($misPizzas) > 0)
                return $misPizzas;
        }
        return null;
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

    public function Vender($ruta, $cantidad)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            if(self::PizzaIsInListPizzas($pizzas, $this))
            {
                foreach ($pizzas as $key => $pi)
                {
                    if($pi->id == $this->id)
                    {
                        $pizzas[$key]->cantidad -= $cantidad;
                        break;
                    }
                }
                return self::GuardarTodo($pizzas, $ruta);
            }
        }
        return false;
    }

    public function BorrarPizza($ruta)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            if(self::PizzaIsInListPizzas($pizzas, $this))
            {
                foreach ($pizzas as $key => $pi)
                {
                    if($pi->id == $this->id)
                    {
                        unset($pizzas[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($pizzas, $ruta);
            }
        }
        return false;
    }

    public static function TraerMayorId($pizzas)
    {
        $maxId = $pizzas[0]->id;
        foreach ($pizzas as $pi)
        {
            if($pi->id > $maxId)
                $maxId = $pi->id;
        }
        return $maxId;
    }

    public static function RetornarIdStock($ruta, $sabor, $tipo, $cantidad)
    {
        $pizzas = self::Cargar($ruta);
        if($pizzas != null)
        {
            foreach ($pizzas as $pi)
            {
                if($pi->sabor == $sabor &&
                    $pi->tipo == $tipo &&
                    $pi->cantidad >= $cantidad)
                    return $pi->id;
            }
        }
        return null;
    }
}
?>