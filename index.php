<?php
declare (strict_types = 1);

require_once 'classes/Main.php';
require_once 'classes/Chart.php';
require_once 'classes/Html.php';

$main = new Main();
$chart = new Chart();

$main->checkAmountOfCurrencies();
Html::initialHtmlCode();

foreach ($main->getCurrenciesCodesArray() as $currencyCode) {
    $main->downloadCurrencyRatesFromServer($currencyCode);
    $chart->createDatesAndRatesArrays();
    $chart->displayChart();
    $chart->resetChartVariables();
}

Html::htmlForFooter();
Html::finalHtmlCode();