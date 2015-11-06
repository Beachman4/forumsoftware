<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;

class CategoryController
{
    public function show()
    {
        $categories = Capsule::table('categories')->get();
        return ['categories'    =>  $categories];
    }
    
    
}

?>