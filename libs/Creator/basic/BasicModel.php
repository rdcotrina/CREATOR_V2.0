<?php
/**
 * Description of BasicModel
 *
 * @author RDCC
 */
class BasicModel {
    
    public static function create($ruta,$opcion,$pre){
        /*crear archivo model BASICO*/
        $capitaleOpcion = Functions::capitalize($opcion);
        $contenido = '<?php
/*
* ---------------------------------------
* --------- CREATED BY CREATOR ----------
* fecha: '.date('d-m-Y H:m:s').' 
* Descripcion : '.$capitaleOpcion.'Model.php
* ---------------------------------------
*/ 

class '.$capitaleOpcion.'Model extends Model{

    private $_flag;
    private $_id'.$capitaleOpcion.';
    private $_activo;
    private $_usuario;
    
    /*para el grid*/
    private $_pDisplayStart;
    private $_pDisplayLength;
    private $_pSortingCols;
    private $_pSearch;
    private $_pOrder;
    private $_sFilterCols;
    
    public function __construct() {
        parent::__construct();
        $this->_set();
    }
    
    private function _set(){
        $this->_flag        = SimpleForm::getParam("_flag");
        $this->_id'.$capitaleOpcion.'   = Aes::de(SimpleForm::getParam("_id'.$capitaleOpcion.'"));    /*se decifra*/
        $this->_activo =   SimpleForm::getParam('.$pre.'."chk_activo");
        $this->_usuario     = Session::get("sys_idUsuario");
        
        $this->_pDisplayStart  =   SimpleForm::getParam("pDisplayStart"); 
        $this->_pDisplayLength =   SimpleForm::getParam("pDisplayLength"); 
        $this->_pSortingCols   =   SimpleForm::getParam("pSortingCols");
        $this->_pSearch        =   SimpleForm::getParam("pSearch");
        $this->_pOrder         =   SimpleForm::getParam("pOrder");
        $this->_sFilterCols    =   htmlspecialchars(trim(AesCtr::de(SimpleForm::getParam("sFilterCols"))),ENT_QUOTES);
    }
    
    /*data para el grid: '.$capitaleOpcion.'*/
    public function getGrid'.$capitaleOpcion.'(){
        $query = "call sp [NOMBRE_PROCEDIMIENTO_GRID] Grid(:iDisplayStart,:iDisplayLength,:sOrder,:sSearch,:sFilterCols);";
        
        $parms = array(
            ":iDisplayStart" => $this->_pDisplayStart,
            ":iDisplayLength" => $this->_pDisplayLength,
            ":sOrder" => $this->_pOrder,
            ":sSearch" => $this->_pSearch ,
            ":sFilterCols" => $this->_sFilterCols,
        );
        $data = $this->queryAll($query,$parms);
        return $data;
    }
    
    /*mantenimiento (CRUD) registro: '.$capitaleOpcion.'*/
    public function mantenimiento'.$capitaleOpcion.'(){
        /*-------------------------LOGICA PARA EL INSERT------------------------*/
    }
    
    /*seleccionar registro a editar: '.$capitaleOpcion.'*/
    public function find'.$capitaleOpcion.'(){
        /*-----------------LOGICA PARA SELECT REGISTRO A EDITAR-----------------*/
    }
    
}
';    
        $r = $ruta['app'].'/modules/'.$ruta['modulo'].'/models/';
        
        if(file_exists($r.$capitaleOpcion.'Model.php')){
            throw new Exception('Archivo: '.$r.$capitaleOpcion.'Model.php ya existe.');
        }else{
            $fp=fopen($r.$capitaleOpcion.'Model.php',"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
        }
    }
    
}
