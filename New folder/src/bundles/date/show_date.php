<?php
namespace App\bundles\date;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class show_date extends Bundle {
    public function show(){
        return date('Ymd');
    }
}

