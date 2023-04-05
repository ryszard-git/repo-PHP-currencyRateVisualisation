<?php
declare (strict_types = 1);
/**
 * Description of Main
 *
 * @author ryszard
 */
class Main {
    private static array $downloadedCurrencyExchangeRatesArray = array();
    private static string $downloadedCurrencyLongName = "";
    private static string $downloadedCurrencyCode = "";
    private string $currency = "";
    private string $currencies = "";
    private array $currenciesCodesArray = array();
      
    public function __construct() {
        $this->currency = (!empty($_GET['currency']) && 
                strlen($_GET['currency']) == 3) ? $_GET['currency'] : 'EUR' ;
        
        $this->currencies = (!empty($_GET['currencies'])) ? $_GET['currencies'] : 'EUR' ;
        define("CURRENCY_RATES_HISTORY_IN_DAYS", "7");
    }
    
    public static function getDownloadedCurrencyLongName(): string {
        return self::$downloadedCurrencyLongName;
    }
    
    public static function getDownloadedCurrencyCode(): string {
        return self::$downloadedCurrencyCode;
    }

    public static function getDownloadedCurrencyExchangeRatesArray(): array {
        return self::$downloadedCurrencyExchangeRatesArray;
    }

    public function getCurrenciesCodesArray(): array {
        return $this->currenciesCodesArray;
    }

    public function checkAmountOfCurrencies() : void {
        $isThereMultipleCurrencies = ((!empty($this->currencies)) &&
                (strpos($this->currencies, ":"))) ? true : false;

        if ($isThereMultipleCurrencies) {
            $this->currenciesCodesArray = explode(":", $this->currencies);
        } else {
            $this->currenciesCodesArray[0] = $this->currency;
        }
    }
    
    public function downloadCurrencyRatesFromServer(string $currencyCode) : void {
        
        $currencyRateServerURL = "https://api.nbp.pl/api/exchangerates/rates/A/" .
                $currencyCode . "/last/" . CURRENCY_RATES_HISTORY_IN_DAYS .
                "/?format=json";

        $currencyObject = file_get_contents($currencyRateServerURL); 
        $jsonObject = json_decode($currencyObject);
        
        $this->setFetchedValuesForVariables($jsonObject);           
    }
    
    private function setFetchedValuesForVariables(object $jsonObject) : void {
        self::$downloadedCurrencyExchangeRatesArray = $jsonObject->rates;     
        self::$downloadedCurrencyLongName = $jsonObject->currency;
        self::$downloadedCurrencyCode = $jsonObject->code;
    }
}