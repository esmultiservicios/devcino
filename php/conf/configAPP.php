<?php
    /*
        Parametros de conexión a la DB
    */
	date_default_timezone_set('America/Tegucigalpa');
    const SERVERURL = "http://localhost/githubCino/";
	const SERVEREMPRESA = "CIN-0";
	const SERVER = "localhost";
    const DB = "clinicarehn_clinicare_cino";
    const USER = "clinicarehn_clinicare";
    const PASS = "Cl|n1c@r32022#%.";
    const PRODUCT_PATH = "/githubCino/upload/";

    /*
        Para encrptar y Desencriptar
        Nota: Estos valores no se deben cambiar, si hay datos en la DB    
    */
    const METHOD = "AES-256-CBC";
    const SECRET_KEY = '$DP_@2020';
    const SECRET_IV = '10172';