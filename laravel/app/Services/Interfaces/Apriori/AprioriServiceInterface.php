<?php

namespace App\Services\Interfaces\Apriori;


interface AprioriServiceInterface
{
    public function exportOrdersToCsv();
    public function suggestProducts($targetProductId, $topN = 3);
}
