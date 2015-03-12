<?php
class BasicController{
 
    public static function create($ruta,$opcion,$pre){
        /*crear archivo controller BASICO*/
        $capitaleOpcion = Functions::capitalize($opcion);
        
        $contenido='<?php
/*
* ---------------------------------------
* --------- CREATED BY CREATOR ----------
* fecha: '.date('d-m-Y H:m:s').' 
* Descripcion : '.$capitaleOpcion.'Controller.php
* ---------------------------------------
*/    

class '.$capitaleOpcion.'Controller extends Controller{
    
    private static $'.$opcion.'Model;
    
    public function __construct() {
        self::$'.$opcion.'Model = $this->loadModel();
    }
    
    public function index(){ 
        Obj::run()->View->render();
    }
    
    public function getGrid'.$capitaleOpcion.'(){
        $rows = array();
        $data =  self::$'.$opcion.'Model->getGrid'.$capitaleOpcion.'();
        foreach ($data as $value) {
            $rows[] = array(
                "LLAVE1"=>AesCtr::en($value["CAMPO1"]),
                "LLAVE2"=> $value["CAMPO2"],
                "LLAVE3"=> $value["CAMPO3"],
                "total"=> $value["total"]
            );
        }
        echo json_encode($rows);
    }
    
    /*carga formulario (formNew'.$capitaleOpcion.'.phtml) para nuevo registro: '.$capitaleOpcion.'*/
    public function formNew'.$capitaleOpcion.'(){
        Obj::run()->View->render();
    }
    
    /*carga formulario (formEdit'.$capitaleOpcion.'.phtml) para editar registro: '.$capitaleOpcion.'*/
    public function formEdit'.$capitaleOpcion.'(){
        Obj::run()->View->render();
    }
    
    /*busca data para editar registro: '.$capitaleOpcion.'*/
    public function find'.$capitaleOpcion.'(){
        $data = self::$'.$opcion.'Model->find'.$capitaleOpcion.'();
            
        return $data;
    }
    
    /*envia datos para grabar registro: '.$capitaleOpcion.'*/
    public function new'.$capitaleOpcion.'(){
        $data = self::$'.$opcion.'Model->mantenimiento'.$capitaleOpcion.'();
        
        echo json_encode($data);
    }
    
    /*envia datos para editar registro: '.$capitaleOpcion.'*/
    public function edit'.$capitaleOpcion.'(){
        $data = self::$'.$opcion.'Model->mantenimiento'.$capitaleOpcion.'();
        
        echo json_encode($data);
    }
    
    /*envia datos para eliminar registro: '.$capitaleOpcion.'*/
    public function delete'.$capitaleOpcion.'(){
        $data = self::$'.$opcion.'Model->mantenimiento'.$capitaleOpcion.'();
        
        echo json_encode($data);
    }
    
}
';
        if(file_exists($ruta['ruta'].$capitaleOpcion.'Controller.php')){
            throw new Exception('Archivo: '.$ruta['ruta'].$capitaleOpcion.'Controller.php ya existe.');
        }else{
            $fp=fopen($ruta['ruta'].$capitaleOpcion.'Controller.php',"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
        }
        
    }
    
}
?>