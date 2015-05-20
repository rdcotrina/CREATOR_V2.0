<?php
/**
 * Description of BasicJs
 *
 * @author RDCC
 */
class BasicJs {
    
    /*crear archivo js BASICO*/
    public static function create($ruta,$opcion,$pre){
        $capitaleOpcion = Functions::capitalize($opcion);
        
        $contenido = '/*
* ---------------------------------------
* --------- CREATED BY CREATOR ----------
* fecha: '.date('d-m-Y H:m:s').' 
* Descripcion : '.$opcion.'.js
* ---------------------------------------
*/
var '.$opcion.'_ = function(){
    
    /*cargar requires*/
    /*descomentar de ser necesario
    simpleObject.require({
        '.$ruta['modulo'].': "'.$opcion.'Script"
    });
    */
    
    /*metodos privados*/
    var _private = {};
    
    _private.id'.$capitaleOpcion.' = 0;
    
    _private.config = {
        modulo: "'.$ruta['modulo'].'/'.$opcion.'/"
    };

    /*metodos publicos*/
    var _public = {};
    
    /*crea tab : '.$capitaleOpcion.'*/
    _public.main = function(){
        simpleScript.addTab({
            id : tabs.'.$pre.',
            label: simpleObject.getTitle(),
            fnCallback: function(){
                '.$opcion.'.getIndex();
            }
        });
    };
    
    /*index del tab: '.$capitaleOpcion.'*/
    _public.getIndex = function(){
        simpleAjax.send({
            dataType: "html",
            root: _private.config.modulo,
            fnCallback: function(data){
                $("#"+tabs.'.$pre.'+"_CONTAINER").html(data);
                '.$opcion.'.getGrid'.$capitaleOpcion.'(true);
            }
        });
    };
    
    _public.getGrid'.$capitaleOpcion.' = function (reload){
        var pEdit   = simpleScript.getPermiso("'.$pre.'ED");
        var pDelete = simpleScript.getPermiso("'.$pre.'DE");

        $("#"+tabs.'.$pre.'+"grid'.$capitaleOpcion.'").simpleGrid({
            tWidthFormat: "px",
            tScrollY: "200px",
            tReload: reload,
            tColumns: [
                {title: lang.'.$opcion.'.CAMPO1,campo: "CAMPO",width: "70",sortable: true,search: {operator:"LIKE"}},
                {title: lang.'.$opcion.'.CAMPO2, campo: "CAMPO", width: "400", sortable: true,search:{operator:"LIKE"}},
                {title: lang.generic.EST, campo: "CAMPO", width: "50", sortable: true, class: "center"}
            ],
            pPaginate: true,
            sAxions: [{
                access: pEdit.permiso,
                icono: pEdit.icono,
                titulo: pEdit.accion,
                class: pEdit.theme,
                ajax: {
                    fn: "'.$opcion.'.getFormEdit'.$capitaleOpcion.'",
                    serverParams: "id_'.$opcion.'"
                }
            }, {
                access: pDelete.permiso,
                icono: pDelete.icono,
                titulo: pDelete.accion,
                class: pDelete.theme,
                ajax: {
                    fn: "'.$opcion.'.postDelete'.$capitaleOpcion.'",
                    serverParams: "id_'.$opcion.'"
                }
            }],
            ajaxSource: _private.config.modulo+"getGrid'.$capitaleOpcion.'",
            fnCallback: function(oSettings) {
                simpleScript.removeAttr.click({
                    container: "#"+oSettings.tObjectTable,
                    typeElement: "button"
                }); 
            }
        });
        setup_widgets_desktop();
    };
    
    _public.getFormNew'.$capitaleOpcion.' = function(btn){
        simpleAjax.send({
            element: btn,
            dataType: "html",
            root: _private.config.modulo + "formNew'.$capitaleOpcion.'",
            fnCallback: function(data){
                $("#cont-modal").append(data);  /*los formularios con append*/
                $("#"+tabs.'.$pre.'+"formNew'.$capitaleOpcion.'").modal("show");
            }
        });
    };
    
    _public.getFormEdit'.$capitaleOpcion.' = function(btn,id){
        _private.id'.$capitaleOpcion.' = id;
            
        simpleAjax.send({
            element: btn,
            dataType: "html",
            root: _private.config.modulo + "formEdit'.$capitaleOpcion.'",
            fnServerParams: function(sData){
                sData.push({name: "_id'.$capitaleOpcion.'", value: _private.id'.$capitaleOpcion.'});
            },
            fnCallback: function(data){
                $("#cont-modal").append(data);  /*los formularios con append*/
                $("#"+tabs.'.$pre.'+"formEdit'.$capitaleOpcion.'").modal("show");
            }
        });
    };
    
    _public.postNew'.$capitaleOpcion.' = function(){
        simpleAjax.send({
            flag: 1,
            element: "#"+tabs.'.$pre.'+"btnGr'.$capitaleOpcion.'",
            root: _private.config.modulo + "new'.$capitaleOpcion.'",
            form: "#"+tabs.'.$pre.'+"formNew'.$capitaleOpcion.'",
            clear: true,
            fnCallback: function(data) {
                if(!isNaN(data.result) && parseInt(data.result) === 1){
                    simpleScript.notify.ok({
                        content: lang.mensajes.MSG_3,
                        callback: function(){
                            '.$opcion.'.getGrid'.$capitaleOpcion.'(false);
                        }
                    });
                }else if(!isNaN(data.result) && parseInt(data.result) === 2){
                    simpleScript.notify.error({
                        content: "'.$capitaleOpcion.' ya existe."
                    });
                }
            }
        });
    };
    
    _public.postEdit'.$capitaleOpcion.' = function(){
        simpleAjax.send({
            flag: 2,
            element: "#"+tabs.'.$pre.'+"btnEd'.$capitaleOpcion.'",
            root: _private.config.modulo + "edit'.$capitaleOpcion.'",
            form: "#"+tabs.'.$pre.'+"formEdit'.$capitaleOpcion.'",
            clear: true,
            fnServerParams: function(sData){
                sData.push({name: "_id'.$capitaleOpcion.'", value: _private.id'.$capitaleOpcion.'});
            },
            fnCallback: function(data) {
                if(!isNaN(data.result) && parseInt(data.result) === 1){
                    simpleScript.notify.ok({
                        content: lang.mensajes.MSG_10,
                        callback: function(){
                            _private.id'.$capitaleOpcion.' = 0;
                            simpleScript.closeModal("#"+tabs.'.$pre.'+"formEdit'.$capitaleOpcion.'");
                            '.$opcion.'.getGrid'.$capitaleOpcion.'(false);
                        }
                    });
                }else if(!isNaN(data.result) && parseInt(data.result) === 2){
                    simpleScript.notify.error({
                        content: "'.$capitaleOpcion.' ya existe."
                    });
                }
            }
        });
    };
    
    _public.postDelete'.$capitaleOpcion.' = function(btn,id){
        simpleScript.notify.confirm({
            content: lang.mensajes.MSG_5,
            callbackSI: function(){
                simpleAjax.send({
                    flag: 3,
                    element: btn,
                    gifProcess: true,
                    root: _private.config.modulo + "delete'.$capitaleOpcion.'",
                    fnServerParams: function(sData){
                        sData.push({name: "_id'.$capitaleOpcion.'", value: id});
                    },
                    fnCallback: function(data) {
                        if(!isNaN(data.result) && parseInt(data.result) === 1){
                            simpleScript.notify.ok({
                                content: lang.mensajes.MSG_6,
                                callback: function(){
                                    '.$opcion.'.getGrid'.$capitaleOpcion.'(false);
                                }
                            });
                        }
                    }
                });
            }
        });
    };
    
    return _public;
    
};
var '.$opcion.' = new '.$opcion.'_();

'.$opcion.'.main(); ';
        
        $r = $ruta['app'].'/modules/'.$ruta['modulo'].'/views/js';
       
        /*crear carpeta para modulo*/
//        if(!file_exists($r)){
//            mkdir($r, 0700);
//        }
        
        if(file_exists($r.'/'.$opcion.'.js')){
            throw new Exception('Archivo: '.$r.$opcion.'.js ya existe.');
        }else{
            $fp=fopen($r.'/'.$opcion.'.js',"x");
            fwrite($fp,$contenido);
            fclose($fp) ;
        }
    }
    
}
