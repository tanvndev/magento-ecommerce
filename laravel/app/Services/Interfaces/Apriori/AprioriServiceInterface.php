<?php

namespace App\Services\Interfaces\Apriori;


interface AprioriServiceInterface
{
    public function exportOrdersToCsv();
    public function getAprioriResultsFromRedis();
}
