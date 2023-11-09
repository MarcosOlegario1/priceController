<?php

namespace App\Console\Commands;

use DOMDocument;
use DOMXPath;
use Exception;
use App\Models\PriceObs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $separatedSites = array();

        $results = PriceObs::all()->toArray();

        function updateItem($array)
        {
            $object = $array;
            DB::table('items')
                    ->where('id', $object['id'])
                    ->update([
                        "price"      => $object['price'],
                        "old_price"  => $object['old_price'],
                        "updated_at" => $object['updated_at'],
                        "updates"    => $object["updates"]
                    ]);
        }

        //Remove unused items from each site (not used only in scrap)
        foreach($results as &$value)
        {
            unset(
                $value['description'],
                $value['reference_id'],
                $value['status'],
                $value['created_at'],
            );
        }

        foreach($results as &$value) 
        {
            $url = parse_url($value['url'], PHP_URL_HOST);
            if(!in_array($url, array_keys($separatedSites)))
            {
                $separatedSites[$url] = [];
            }

            array_push($separatedSites[$url], $value);
        }

        //Since here at TRY, is for progressive scrap, scrapping one site for each array at time
        $maxIndex = 0;
        foreach($separatedSites as &$loopSites) 
        {
            $size = count($loopSites);
            if($size > $maxIndex)
            {
                $maxIndex = $size;
            }
        }

        for($i = 0; $i < $maxIndex; $i++)
        {
            foreach(array_keys($separatedSites) as $url)
            {
               if(!empty($separatedSites[$url][$i]))
               {
                $value = $separatedSites[$url][$i];
                try
                {
                    $httpClient = new \GuzzleHttp\Client([
                        'headers' => [
                            'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:109.0) Gecko/20100101 Firefox/109.0',
                            'Accept-Language' => 'en-US,en;q=0.5',
                            'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                            'cookies'         => true,
                    ]]);
                    $response = $httpClient->get($value['url']);
                    $htmlString = (string) $response->getBody();
                    libxml_use_internal_errors(true);
                    $doc = new DOMDocument();
                    $doc->loadHTML($htmlString);
                    $xpath = new DOMXPath($doc);
                    $titles = $xpath->evaluate($value['reference']);
                    foreach ($titles as $key => $title) 
                    {
                        $newValue = $title->textContent;
                        
                        // if($value['price'] > $newValue || $value['price'] == null)
                        // {
                            $value['old_price']  = $value['price'];
                            $value['price']      = $newValue;
                            $value['updated_at'] = date("Y-m-d H:i:s");
                            $value['updates']    = $value['updates'] + 1;
                            updateItem($value);
                        // }
                    }
                }catch (Exception $e){
                    error_log("Exception:" . $e->getMessage());
                    report($e->getMessage());
                }
               }
            }
        }
    }
}
