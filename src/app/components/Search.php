<?php
namespace App\Components;

use Phalcon\DI\Injectable;

class Search extends Injectable
{
    public function searchInDB($name)
    {
        return $this->mongo->users->findOne(['name' => $name]);
    }
}
