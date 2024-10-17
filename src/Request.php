<?php

class Request {

    public function __construct()
    {
    }

    public static function all()
    {
        $arrReq = [];

        if (!empty($_POST))
        {
            foreach ($_POST as $key => $val) {
                $arrReq[$key] = $val;
            }

            return $arrReq;
        }

        $req = file_get_contents('php://input');

        if (!empty($req))
        {
            $req = json_decode($req, true);

            foreach ($req as $key => $val) {
                $arrReq[$key] = $val;
            }
    
            return $arrReq;
        }
    }
    
}