<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Exception;

class ScraperController extends Controller
{

    private $results = array();

    private $sites = array (
        array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/463074/iphone-14-apple-128gb-meia-noite-tela-de-6-1-5g-camera-dupla-de-12mp-ios-mpuf3br-a'),
        array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/95217/ssd-960-gb-kingston-a400-sata-leitura-500mb-s-e-gravacao-450mb-s-sa400s37-960g'),
        array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/174032/ssd-kingston-480gb-a400-sata-leitura-500mb-s-e-gravacao-450mb-s-sa400s37-480g'),
        array('//*[@id="blocoValores"]/div[2]/div[1]/div/h4', 'https://www.kabum.com.br/produto/471697/notebook-gamer-acer-nitro-5-amd-ryzen-5-7535hs-8gb-nvidia-rtx-3050-ssd-512gb-15-6-full-hd-linux-gutta-preto-an515-47-r5su')
      );

    public function scraper()
    {
        // foreach ($this->sites as $key => $value) {
        //     try{
                
        //         $httpClient = new \GuzzleHttp\Client([
        //             'headers' => [
        //                 'User-Agent' => 'testing/1.0',
        //                 'Accept'     => 'application/json',
        //                 'cookies'    => true,
        //         ]]);
        //         $response = $httpClient->get($value[1]);
        //         $htmlString = (string) $response->getBody();
        //         //add this line to suppress any warnings
        //         libxml_use_internal_errors(true);
        //         $doc = new DOMDocument();
        //         $doc->loadHTML($htmlString);
        //         $xpath = new DOMXPath($doc);
        //         $titles = $xpath->evaluate($value[0]);
        //         foreach ($titles as $key => $title) {
        //             array_push($this->results, $title->textContent);
        //         }
        //         $data = $this->results;
        //         // sleep(15);
        //     }catch (Exception $e){
        //         echo($e->getMessage());
        //     }
        // }


        return view('scraper');
    }
}
