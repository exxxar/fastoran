<?php


namespace App\Classes;


interface iDeliveryService
{
    public function uploadProducts();

    public function getRestoransList();
    public function getRestoranById($id);
}
