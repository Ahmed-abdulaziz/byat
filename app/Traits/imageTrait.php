<?php
namespace App\Traits;

trait imageTrait{

    function storeImages($photo,$folder){

        $file_extintion=$photo->getClientOriginalExtension();
        $file_name=time().random_int(5,30).'.'.$file_extintion;
        $path=$folder;
        $photo->move($path,$file_name);
        return $file_name;

    }



}
