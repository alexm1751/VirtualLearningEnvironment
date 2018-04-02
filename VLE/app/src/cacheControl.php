<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 01/04/2018
 * Time: 17:21
 */



class cacheControl
{
    public function handle($request, $response, $next)
    {
//        if(!isset($_SESSION['user'])){
//            return $request->Redirect('/FinalYearProject/VLE_Public/');
//        }
        $response = $next($request, $response);

        return $response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
            ->headers->set('Pragma', 'no-cache')
            ->headers->set('Expires','Sat, 01 Jan 1990 00:00:00 GMT');
    }
}