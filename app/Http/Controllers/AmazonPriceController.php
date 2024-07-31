<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class AmazonPriceController extends Controller
{
    public function calculatePrice(Request $request)
    {
        $url = $request->input('url');
        $productInfo = $this->getAmazonProductInfo($url);

        $basePrice = $productInfo['price'];
        $shippingCost = 20;
        $importTaxRate = 0.1;
        $profitMargin = 0.2;

        $finalPrice = $this->calculateFinalPrice($basePrice, $shippingCost, $importTaxRate, $profitMargin);
        dd( $productInfo, $finalPrice);
        return view('pages.result-amazon-calc', [
            'productInfo' => $productInfo, 
            'finalPrice' => $finalPrice
        ]);
    }

    private function getAmazonProductInfo($url)
    {
        $client = new Client([
            'cookies' => true
        ]);
        $response = $client->get($url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        // dd($crawler);
        $productTitle = $crawler->filter('span#productTitle')->text();
        // dd($productTitle);
        $productPrice = $crawler->filter('.a-price-whole')->text();

        return ['title' => $productTitle, 'price' => floatval(str_replace(',', '', $productPrice))];
    }

    private function calculateFinalPrice($basePrice, $shippingCost, $importTaxRate, $profitMargin)
    {
        $importTax = $basePrice * $importTaxRate;
        $totalCost = $basePrice + $shippingCost + $importTax;
        $finalPrice = $totalCost * (1 + $profitMargin);
        return $finalPrice;
    }
}
