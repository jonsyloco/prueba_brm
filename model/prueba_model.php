<?php

class prueba_model extends odbc {

    public function __construct() {
        
    }

    /**
     * @autor: jhonatan wagner
     * @fecha: 25/11/2016
     * @description: metodo encargado de insertar lo registros
     * establecidos por el cliente.
     * esto hace referencia a la "barra de progreso"
     */
    public function guardarConfiguracion($registros) {


        $sql2 = "INSERT INTO prueba_progreso (registros) VALUES('$registros')";
        $resp2 = $this->ejecutar($sql2);
        return $resp2;
    }
    
    
    /**
     * @autor: jhonatan wagner
     * @fecha: 25/11/2016
     * @description: metodo encargado de TRAER los servidores activos en el sistema
     * estos servidores, deben estar parametrizados en al tabla SERVIDORES de la base de
     * datos IBG del 100.10 en este momento se tiene restringido a un servidor
     */
     
     
    public function traerServidores(){
        $sql2 = "select id, bd , estado , feact , fecr , ip , odbc , odbc_pass , odbc_user , usact , uscr from servidores where estado='A'";
        $resp = $this->consultar($sql2, __FUNCTION__);
        $i = 0;
        $servidores = array();
        $datosOdbc = $this->getDatosOdbc();
        $i=0;
        while ($reg = $datosOdbc->getRegistro()) {
//            if($reg['odbc']=="ifxcontab1007" && ( $_SESSION['session_intranet_login']!='hectorf')){ //ESTO SE DEBE COLOCAR EN PRODUCCION porque evita, que los usuarios comunes entren en al contabilidad de prueba
            if($reg['odbc']=="ifxcontab1007" && ( $_SESSION['session_intranet_login']!='jwagner')){ //ESTO SE DEBE COLOCAR EN PRODUCCION porque evita, que los usuarios comunes entren en al contabilidad de prueba
                continue;
            }
            $servidores[$i]['id']=$reg['id'];
            $servidores[$i]['bd']=$reg['bd'];
            $servidores[$i]['estado']=$reg['estado'];
            $servidores[$i]['feact']=$reg['feact'];
            $servidores[$i]['fecr']=$reg['fecr'];
            $servidores[$i]['ip']=$reg['ip'];
            $servidores[$i]['odbc']=$reg['odbc'];
            $servidores[$i]['odbc_pass']=$reg['odbc_pass'];
            $servidores[$i]['odbc_user']=$reg['odbc_user'];
            $servidores[$i]['usact']=$reg['usact'];
            $servidores[$i]['uscr']=$reg['uscr'];
            $i++;
        }
        return $servidores;
    }
    
    /**
     * @fecha: 09/feb/2017
     * @autor: jhonatan wagner ocampo
     * @descripcion trae todas las empresas que halla en un servidor
     * @return trae todas las empresas que halla en un servidor
     */
    public function traerEmpresas(){
        $sql2 = "select codigo,nom_empr,odbc,odbc_pass,odbc_user from empresas where estado='A' order by 1";
        $resp = $this->consultar($sql2, __FUNCTION__);
        $i = 0;
        $empresa = array();
        $datosOdbc = $this->getDatosOdbc();
        $i=0;
        while ($reg = $datosOdbc->getRegistro()) {
            $empresa[$i]['codigo']=$reg['codigo'];
            $empresa[$i]['nom_empr']=$reg['nom_empr'];
            $empresa[$i]['odbc']=$reg['odbc'];
            $empresa[$i]['odbc_user']=$reg['odbc_user'];
            $empresa[$i]['odbc_pass']=$reg['odbc_pass'];
            
            $i++;
        }
        return $empresa;
    }
    
    /**
     * @autor: jhonatan wagner
     * @fecha: 25/11/2016
     * @description: metodo que me trae todos los programas, almacenados en la
     * base de datos, estos programas depende DIRECTAMENTe del servidor elegido
     * previamente. debe haber una tabla llamada PROGRAMAS en esa basede datos 
     * que se esta consultando.
     */
    public function traerProgramas($usuario,$empresa) {
//        $sql2 = "select codigo, grupo, nombre from programas where codigo not in (select programa from usuaprogra up inner join usu_empr ue on (ue.codigo=up.usu_empresa_id) where ue.id_user='$usuario' and id_empr='$empresa')";
        $sql2 = "select p.codigo, p.grupo, p.nombre from programas p where p.codigo not in (select programa from usuaprogra up inner join usu_empr ue on (ue.codigo=up.usu_empresa_id) where ue.id_user='$usuario' and ue.id_empr='$empresa' and up.estado='A') and p.estado='A'";
        $resp = $this->consultar($sql2, __FUNCTION__);
        $i = 0;
        $programa = array();
        $datosOdbc = $this->getDatosOdbc();
        $i=0;
        while ($reg = $datosOdbc->getRegistro()) {
            $programa[$i]['codigo']=$reg['codigo'];
            $programa[$i]['grupo']=  utf8_encode($reg['grupo']);
            $programa[$i]['nombre']=  utf8_encode($reg['nombre']);
            
            $i++;
        }
        return $programa; 
    }
    
    /**
     * @autor: jhonatan wagner
     * @fecha: 25/11/2016
     * @description: metodo que me trae todos los Usuarios, almacenados en la
     * base de datos, de MYSQL, es la apropiada por que todos los usuarios de la
     * intranet estan aqui.. el filtro que se tiene es por seccion donde 12-2 es
     * contabilidad.
     */
    public function traerUsuarios() {
        $sql2 = "SELECT concat(login,' - ',cod_emp) empleado,cod_emp,login FROM empleado where cod_seccion='12-S' and activo='1' or login='macosta' or login='hsquinteos';";
        $resp = $this->consultar($sql2, __FUNCTION__);
        $i = 0;
        $usuario = array();
        $datosOdbc = $this->getDatosOdbc();
        $i=0;
        while ($reg = $datosOdbc->getRegistro()) {
            $usuario[$i]['login']=$reg['login'];            
            $usuario[$i]['cod_emp']=$reg['cod_emp'];            
            $usuario[$i]['empleado']=$reg['empleado'];            
            
            $i++;
        }
        return $usuario; 
    }
    
    /**
     * @autor jhonatan wagner ocampo
     * @param type $usuario
     * @param type $empresa
     * @descripcion: metodo que identifica si hay una relacion activa en la tabla usu_empr
     * @return 0 si no hay usuarios y empresas relacionados, 1 si existe alguna relacion en la base de datos
     */
    public function verificarUsuaEmpr($usuario,$empresa) {
       $sql="select count(*) cant from usu_empr where id_empr='$empresa' and id_user='$usuario' and estado='A'"; 
       
       $resp = $this->consultar($sql, __FUNCTION__);
       $datosOdbc = $this->getDatosOdbc();
       $cant=0;
       $i = 0;
        while ($reg = $datosOdbc ->getRegistro()) {
            $cant=$reg['cant'];            
        }
        if($cant>0){
            return 1;
        }else{
            return 0;
        }
            
    }
    /**
     * @autor jhonatan wagner
     * @descripcion metodo que inserta la realcion entre usuarios y empresas
     * @param type $usuario
     * @param type $empresa
     * @return type
     */
    public function insertarUsuEmpr($usuario,$empresa) {
        $sql="insert into usu_empr(  estado ,  fecr ,  id_empr ,  id_user ,  uscr) values ('A',current,'$empresa','$usuario','{$_SESSION['session_intranet_login']}')";
        
        $resp2 = $this->ejecutar($sql);
        return $resp2;
    }
    
    
    /**
     * 
     * @param type $usuario
     * @param type $empresa
     * @descripcion metodo encargado de verificar en BD si el usuario tiene o no empresas asociadas
     * @return un valor numerico indicando si el usuairo tiene o no esa empresa asociada a el
     */
    public function traerIdUsuEmpr($usuario,$empresa) {
       $sql="select codigo from usu_empr where id_empr='$empresa' and id_user='$usuario' and estado='A'"; 
       
       $resp = $this->consultar($sql, __FUNCTION__);
       $datosOdbc = $this->getDatosOdbc();
       $cant=0;
       $i = 0;
        while ($reg = $datosOdbc ->getRegistro()) {
            $cant=$reg['codigo'];            
        }
        if(count($cant)>0){
            return $cant;
        }else{
            return 0;
        } 
    }
    /**
     * @fecha 09/feb/2017
     * @autor jhonatan wagner ocampo
     * @descripcion metodo encargado de insertar los permisos al usuario y programa escogido
     * @param type $insert
     * @param type $modifi
     * @param type $Anular
     * @param type $ejecu
     * @param type $print
     * @param type $login
     * @param type $prograId
     * @param type $usuEmprID
     * @param type $empresa
     * @return 0-inserto 1-no inserto
     */
    public function insertUsuaProgra($insert,$modifi,$Anular,$ejecu,$print,$login,$prograId,$usuEmprID,$empresa) {
        $programas=  $this->traerProgramas($login, $empresa);
        $contador=0;
        $s="";
        for ($i = 0; $i < count($programas); $i++) {
            if($programas[$i]['codigo']==$prograId){
                $contador++;
            }            
        }
        if($contador!=0){
            $sql="insert into usuaprogra(consulta,ejecucion,eliminacion,estado,fecadd,impresion,insercion,login,modificacion,programa,usu_empresa_id,usuadd ) values ('S','$ejecu','$Anular','A',current,'$print','$insert','$login','$modifi','$prograId','$usuEmprID','{$_SESSION['session_intranet_login']}')";    
            $resp2 = $this->ejecutar($sql);
            return $resp2;   
            
        }else{
            return 1;
        }
        }
        /**
         * @fecha 09/feb/2017
         * @autor jhonatan wagner
         * @descripcion trae todas las empresas que los usuarios tengan asociados,
         * esta tabla se visualiza en la interfaz para observar todas las relaciones de un servidor
         * @return array de usuario empresa
         */
        public function traerUsuEmpr() {
//            $sql="select codigo,id_empr,(select em.nom_empr from empresas em where em.codigo=id_empr) empresa,id_user,uscr,fecr,usact,feact from usu_empr where estado='A'";
            $sql="select codigo,id_empr,(select em.nom_empr from empresas em where em.codigo=id_empr) empresa,(select em.odbc from empresas em where em.codigo=id_empr) odbc,(select em.odbc_user from empresas em where em.codigo=id_empr) user,(select em.odbc_pass from empresas em where em.codigo=id_empr) pass,id_user,uscr,fecr,usact,feact from usu_empr where estado='A'";
            $resp = $this->consultar($sql, __FUNCTION__);
            $i = 0;
            $usuEmpr = array();
            $datosOdbc = $this->getDatosOdbc();
            while ($reg = $datosOdbc->getRegistro()) {
                $usuEmpr[$i]['codigo']=$reg['codigo'];            
                $usuEmpr[$i]['id_empr']=$reg['id_empr'];            
                $usuEmpr[$i]['empresa']=$reg['empresa'];            
                $usuEmpr[$i]['id_user']=$reg['id_user'];            
                $usuEmpr[$i]['odbc']=$reg['odbc'];            
                $usuEmpr[$i]['user']=$reg['user'];            
                $usuEmpr[$i]['pass']=$reg['pass'];            
                $usuEmpr[$i]['uscr']=$reg['uscr'];            
                $usuEmpr[$i]['fecr']=$reg['fecr'];            
                $usuEmpr[$i]['usact']=$reg['usact'];            
                $usuEmpr[$i]['feact']=$reg['feact'];            

                $i++;
            }
            
            return $usuEmpr;
        }
        /**
         * @author jhonatan wagner ocampo
         * @fecha 09/feb/2017
         * @descripcion: metodo para verificare que halla una relación
         * en la tabla usua_empr, para la posterior eliminacion del registro
         * @return 0-no hay relacion 1-hay relacion activa
         */
        public function verificaUsuEmpr($empresa,$usuario) {
            $sql="select count(*)cant from usu_empr where id_user='$usuario' and id_empr='$empresa' and estado='A'";
            $resp = $this->consultar($sql, __FUNCTION__);            
            $cant = 0;
            $datosOdbc = $this->getDatosOdbc();
            while ($reg = $datosOdbc->getRegistro()) {
                $cant=$reg['cant'];  
                
            }
            return $cant;
            
        }
        /**
         * @author jhonatan wagner ocampo
         * @fecha 09/feb/2017
         * @descripcion: metodo para verificar que halla una relacion entre
         * usuario, empresa y programas, para la posterior eliminacion
         * @return: 0-no hay relacion N..-hay relacion(es) activas
         */
        public function verificaUsuProgra($empresa,$usuario) {
            $sql="select count(*)cant from usuaprogra up where up.usu_empresa_id=(select ue.codigo from usu_empr ue where ue.id_empr='$empresa' and ue.id_user='$usuario' and estado='A') and estado='A'";
            $resp = $this->consultar($sql, __FUNCTION__);            
            $cant = 0;
            $datosOdbc = $this->getDatosOdbc();
            while ($reg = $datosOdbc->getRegistro()) {
                $cant=$reg['cant'];  
                
            }
            return $cant;
        }
        /**
         * @author jhonatan wagner ocampo
         * @fecha 09/feb/2017
         * @descripcion: metodo que sirve para eliminar la relacion entre
         * el usuario y la empresa, se debe usar de segundo, primero se debe
         * usar el eliminar la relacion de usuario y programas
         * @return 0- se elimino la relacion 1-un error en base de datos
         */
        public function eliminarUsuEmpr($empresa,$usuario) {
            
            $sql="update usu_empr set estado='I',usact='admin',feact=current where id_user='$usuario' and id_empr='$empresa' and estado='A'";
            $resp2 = $this->ejecutar($sql);
            return $resp2;  
        }
        /**
         * @author jhonatan wagner ocampo
         * @fecha 09/feb/2017
         * @descripcion: metodo que sirve para eliminar la relacion entre
         * el usuario y el programa, se debe aplicar primero este metodo, y proseguido
         * utilizar la eliminacion de usuEmpr, para que la integridad de los datos se
         * mantega, no debe quedar relacion sin eliminar.
         * @return 0- se elimino correctamente 1-un problema en base de datos 
         */
        public function eliminarUsuProgra($empresa,$usuario) {
            $sql="update usuaprogra set estado='I',usumod='{$_SESSION['session_intranet_login']}',fecmod=current where usu_empresa_id=(select ue.codigo from usu_empr ue where ue.id_empr='$empresa' and ue.id_user='$usuario' and ue.estado='A') and estado='A'";
            $resp2 = $this->ejecutar($sql);
            return $resp2;  
        }
     
        
           /**
         * @fecha 09/feb/2017
         * @autor jhonatan wagner
         * @descripcion trae todas las empresas que los usuarios tengan asociados,
         * esta tabla se visualiza en la interfaz para observar todas las relaciones de un servidor
         * @return array de usuario empresa
         */
        public function empresasUsuario($usu,$ip) {
//            $sql="select codigo,id_empr,(select em.nom_empr from empresas em where em.codigo=id_empr) empresa,id_user,uscr,fecr,usact,feact from usu_empr where estado='A'";
            $sql="select codigo,id_empr,(select em.nom_empr from empresas em where em.codigo=id_empr) empresa,(select em.odbc from empresas em where em.codigo=id_empr) odbc,(select em.odbc_user from empresas em where em.codigo=id_empr) user,(select em.odbc_pass from empresas em where em.codigo=id_empr) pass,id_user,uscr,fecr,usact,feact from usu_empr where estado='A' and id_user='$usu'";
            $resp = $this->consultar($sql, __FUNCTION__);
            $i = 0;
            $usuEmpr = array();
            $datosOdbc = $this->getDatosOdbc();
            while ($reg = $datosOdbc->getRegistro()) {
                $usuEmpr[$i]['codigo']=$reg['codigo'];            
                $usuEmpr[$i]['id_empr']=$reg['id_empr'];            
                $usuEmpr[$i]['empresa']=$reg['empresa']." (".$ip.")";//se le agrego la ip del servidor de la empresa 18/mayo/2016            
                $usuEmpr[$i]['id_user']=$reg['id_user'];            
                $usuEmpr[$i]['odbc']=$reg['odbc'];            
                $usuEmpr[$i]['user']=$reg['user'];            
                $usuEmpr[$i]['pass']=$reg['pass'];            
                $usuEmpr[$i]['uscr']=$reg['uscr'];            
                $usuEmpr[$i]['fecr']=$reg['fecr'];            
                $usuEmpr[$i]['usact']=$reg['usact'];            
                $usuEmpr[$i]['feact']=$reg['feact'];            
                $usuEmpr[$i]['ip']=$ip;   //se agrega la ip para obtener mas facil este item, para hacer FTP en algunas apps 15/julio/2017            

                $i++;
            }
            
            return $usuEmpr;
        }
        
            
}
    

?>