<?php

    class connectionDBsqlServer {
        public function connDBsqlServer() {
            $instance = '172.25.8.25\SQLSTD2017, 1433';
            //172.25.8.25: 1433 - 49178 - 54724
            $usr = 'sa';
            $password = 'cha9455..';
            $conectionInfo = array('Database'=>'spReprocess', 'UID'=>'sa', 'PWD'=>'cha9455..', 'CharacterSet' => 'UTF-8');

            $con = sqlsrv_connect($instance, $conectionInfo);
            if($con != true) {
                die( print_r( sqlsrv_errors(), true));
            }

            return $con;
        }
    }

?>