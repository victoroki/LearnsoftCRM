<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Flash;

class ClientController extends AppBaseController
{
    /** @var ClientRepository $clientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the Client.
     */
/**
 * Display a listing of the Client.
 */
/**
 * Display a listing of the Client.
 */
public function index(Request $request)
{
    // Get search term from the request
    $search = $request->input('search');
    
    // Query clients with related data
    $clients = $this->clientRepository->query()->with('lead'); // Include related lead data
    
    // Apply search filters dynamically
    if ($search) {
        $clients = $clients->where(function ($query) use ($search) {
            $query->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%')
                  ->orWhere('email_address', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhereHas('lead', function ($query) use ($search) {
                      $query->where('name', 'like', '%' . $search . '%');
                  }); // Search the related lead's name
        });
    }
    
    // Paginate results (10 per page, adjustable)
    $clients = $clients->paginate(10);
    
    return view('clients.index', compact('clients'));
}

    /**
     * Show the form for creating a new Client.
     */
    public function create()
    {
        // Fetch all leads and pass them to the view
        $leads = \App\Models\Lead::all();
        return view('clients.create', compact('leads'));  
    }

    /**
     * Store a newly created Client in storage.
     */
    public function store(CreateClientRequest $request)
    {
        $input = $request->all();
        $client = $this->clientRepository->create($input);

        Flash::success('Client saved successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified Client.
     */
    public function show($id)
    {
        // Ensure that $id is being passed properly
        $client = $this->clientRepository->find($id);
    
        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }
    
        // Eager load the 'lead' relationship after finding the client
        $client->load('lead'); 
    
        return view('clients.show')->with('client', $client);
    }
    

    /**
     * Show the form for editing the specified Client.
     */
    public function edit($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        return view('clients.edit')->with('client', $client);
    }

    /**
     * Update the specified Client in storage.
     */
    public function update($id, UpdateClientRequest $request)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $client = $this->clientRepository->update($request->all(), $id);

        Flash::success('Client updated successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified Client from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $this->clientRepository->delete($id);

        Flash::success('Client deleted successfully.');

        return redirect(route('clients.index'));
    }
}
