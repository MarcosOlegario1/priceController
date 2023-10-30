<?php

namespace App\Console\Commands;

use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Logger\ConsoleLogger;

class MakeScrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data value using scrap by schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $results = array();

        $sites = array (
            array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/463074/iphone-14-apple-128gb-meia-noite-tela-de-6-1-5g-camera-dupla-de-12mp-ios-mpuf3br-a'),
            array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/95217/ssd-960-gb-kingston-a400-sata-leitura-500mb-s-e-gravacao-450mb-s-sa400s37-960g'),
            array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/174032/ssd-kingston-480gb-a400-sata-leitura-500mb-s-e-gravacao-450mb-s-sa400s37-480g'),
            array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/471697/notebook-gamer-acer-nitro-5-amd-ryzen-5-7535hs-8gb-nvidia-rtx-3050-ssd-512gb-15-6-full-hd-linux-gutta-preto-an515-47-r5su')
        );

        foreach ($sites as $key => $value) {
            try{
                $httpClient = new \GuzzleHttp\Client([
                    'headers' => [
                        'User-Agent' => 'testing/1.0',
                        'Accept'     => 'application/json',
                        'cookies'    => true,
                ]]);
                $response = $httpClient->get($value[1]);
                $htmlString = (string) $response->getBody();
                libxml_use_internal_errors(true);
                $doc = new DOMDocument();
                $doc->loadHTML($htmlString);
                $xpath = new DOMXPath($doc);
                $titles = $xpath->evaluate($value[0]);
                foreach ($titles as $key => $title) {
                    error_log($title->textContent);
                    array_push($results, $title->textContent);
                }
                $data = $results;
                //data returns array of strings obviously
            }catch (Exception $e){
                error_log('Error in item:' . $value);
                error_log("Exception:" . $e->getMessage());
                echo($e->getMessage());
            }
        }
    }
}
