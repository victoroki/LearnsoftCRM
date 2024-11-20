<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use App\Models\Client;
use App\Models\Product;
use App\Models\Report;

class SyncReportsData extends Command
{
    protected $signature = 'sync:reports';
    protected $description = 'Sync data from leads, clients, and products into the reports table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $leads = Lead::all();
        $clients = Client::all();
        $products = Product::all();

        // Loop through each lead and client pair
        foreach ($leads as $lead) {
            foreach ($clients as $client) {

                $existingReport = Report::where('lead_id', $lead->id)
                    ->where('client_id', $client->id)
                    ->first();

                // Only create a new report if one doesn't exist yet
                if (!$existingReport) {
                    // Create a report only if there's a product
                    foreach ($products as $product) {
                        Report::create([
                            'lead_id' => $lead->id,
                            'client_id' => $client->id,
                            'lead_date' => $lead->lead_date,
                            'client_date' => $client->client_date,
                            'product_id' => $product->id,
                            'quantity_ordered' => 0, // Default value
                        ]);
                    }
                }
            }
        }

        $this->info('Reports data synced successfully.');
    }
}
