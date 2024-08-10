<?php

namespace App\Http\Controllers;

use App\Services\AmazonService;
use Illuminate\Http\Request;

class PriceCalculatorController extends Controller
{
    protected $amazonService;

    public function __construct(AmazonService $amazonService)
    {
        $this->amazonService = $amazonService;
    }

    public function showForm()
    {
        return view('price-calculator');
    }

    public function calculatePrice(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        // Extract ASIN from URL
        $asin = $this->extractAsinFromUrl($request->input('url'));

        
        $productDetails = $this->amazonService->getProductDetails($asin);

        // Implement calculation logic here

        return view('price-result', ['productDetails' => $productDetails]);
    }

    private function extractAsinFromUrl($url)
    {
        // Implement ASIN extraction logic
        // This is a placeholder

        try {
            preg_match('/\/([A-Z0-9]{10})(?:[\/?]|$)/', $url, $matches);
    
        if (isset($matches[1])) {
            return $matches[1]; // Retorna el ASIN encontrado
        }
            //$result = $this->apiInstance->getListingsItem(config('amazon.marketplace_id'), $asin, ['includedData' => ['summaries']]);
           // return $result;
        } catch (Exception $e) {
            throw new \InvalidArgumentException('Could not fetch product details: ' . $e->getMessage());
        }
       // return 'B08B13JGN4';
    }
}
