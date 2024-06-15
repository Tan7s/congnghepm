<?php
namespace App\Services;
class BaseService
{
    function __construct()
    {   

        $this->validation = \Config\Services::validation();
    }
}
?>