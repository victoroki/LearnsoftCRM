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

        foreach ($leads as $lead) {
            foreach ($clients as $client) {
                foreach ($products as $product) {
                    Report::create([
                        'lead_name' => $lead->lead_name,
                        'client_name' => $client->client_name,
                        'lead_date' => $lead->lead_date,
                        'client_date' => $client->client_date,
                        'product_id' => $product->id,
                        'quantity_ordered' => 0, // Default value or calculated
                    ]);
                }
            }
        }

        $this->info('Reports data synced successfully.');
    }
}

