<?php
declare (strict_types = 1);
/**
 * Description of Chart
 *
 * @author ryszard
 */
require_once 'classes/Html.php';

class Chart {
    private array $dayRate = array();
    private array $dateOfRate = array();
    private string $dayRateToChart = "";
    private string $datesOfRateToChart = "";

    public function createChart() : string {
        
        $currencyLongName = Main::getDownloadedCurrencyLongName();
        $currencyCode = Main::getDownloadedCurrencyCode();
                
        $this->prepareVariablesToChart();
        
        $maxDayRateOnChart = round(max($this->dayRate) + 0.01, 4);
        $minDayRateOnChart = round(min($this->dayRate) - 0.005, 4);

        $rateInterval = round(($maxDayRateOnChart - $minDayRateOnChart) / 4, 4);

        // DO NOT change the indentation of the following code snippet *****

        $chartGeneratorURL = "https://image-charts.com/chart?cht=lc
&chtt=$currencyLongName%20$currencyCode
&chxt=x,y
&chxl=0:|$this->datesOfRateToChart
&chs=900x400
&chd=t:$this->dayRateToChart
&chxr=1,$minDayRateOnChart,$maxDayRateOnChart,$rateInterval";

        // *****************************************************************
        
        return $chartGeneratorURL;
    }
    
    private function prepareVariablesToChart() {
        $this->dayRateToChart = implode(",", $this->dayRate);    
        $this->datesOfRateToChart = implode("|", $this->dateOfRate);
    }
    
    public function createDatesAndRatesArrays() {
        $rates = Main::getDownloadedCurrencyExchangeRatesArray();

        foreach ($rates as $rateItem) {
            $this->createRatesArray($rateItem);
            $this->createDatesArray($rateItem);
        }
    }
    
    private function createRatesArray($rateItem) {
        foreach ($rateItem as $key => $value) {
            if ($key == "mid") {
                $this->dayRate[] = $value;
            }
        }
    }
    
    private function createDatesArray($rateItem) {
        foreach ($rateItem as $key => $value) {
            if ($key == "effectiveDate") {
                $this->dateOfRate[] = $value;
            }
        }
    }
    
    public function resetChartVariables() {
        $this->dayRateToChart = "";
        $this->datesOfRateToChart = "";
        $this->dateOfRate = array();
        $this->dayRate = array();
    }
    
    public function displayChart() {
        Html::htmlForDisplayChart($this->createChart());
    }
}