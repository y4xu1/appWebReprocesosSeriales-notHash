<?php

    class connectionDB {
        public function connDB() {
            
            $connName = 'BAAN PRD';//BAAN PRD - BAAN PRUEBAS
            $server = '172.25.8.58';//172.25.8.58 - 172.25.8.77
            $port = '1521';//
            $service = 'baan';//
            $user = 'baan';//
            $pssword = 'baan';//
            $url = $server.'/'.$service;
            $mess = null;

            try {
                $conn = oci_connect($user, $pssword, $url);
            } catch (Exception $e) {
                $mess = "No se logró conexión con la base de datos de " . $connName . "\n" . $e + "\n" . oci_error();
                echo '<script>alert("No se logró conexión con la base de datos de '. $connName .'")</script>';
            }
            return $conn;
        }
    }
?>