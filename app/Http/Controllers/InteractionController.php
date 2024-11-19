<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInteractionRequest;
use App\Http\Requests\UpdateInteractionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InteractionRepository;
use Illuminate\Http\Request;
use App\Models\Interaction;
use App\Models\Client;  // Correct import at the top
use App\Models\Lead;
use Flash;

class InteractionController extends AppBaseController
{
    /** @var InteractionRepository $interactionRepository */
    private $interactionRepository;

    public function __construct(InteractionRepository $interactionRepo)
    {
        $this->interactionRepository = $interactionRepo;
    }

    /**
     * Display a listing of the Interaction.
     */
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');
    
        // Query interactions grouped by lead_id with aggregated data for other columns
        $interactions = Interaction::with(['lead'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    // Search in the 'interactions' table itself
                    $subQuery->where('type', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%')
                             ->orWhere('interactions_date', 'like', '%' . $search . '%')
                             
                             // Search in the related 'lead' table
                             ->orWhereHas('lead', function ($query) use ($search) {
                                 $query->where('full_name', 'like', '%' . $search . '%')
                                       ->orWhere('email', 'like', '%' . $search . '%');
                             });
                });
            })
            // Use GROUP_CONCAT to aggregate interactions for each lead
            ->selectRaw('MAX(interactions.id) as interaction_id, lead_id, MAX(interactions.type) as type, MAX(interactions.description) as description, MAX(interactions.interactions_date) as interaction_date')
            ->groupBy('lead_id')  // Group by lead_id
            ->paginate(10); // Paginate the results
    
        return view('interactions.index', compact('interactions'));
    }
    
    
    

    /**
     * Show the form for creating a new Interaction.
     */
    public function create(Request $request)
    {
        // Retrieve lead_id or client_id from the query string
        $leadId = $request->query('lead_id');
        $clientId = $request->query('client_id');
    
        $lead = null;
        $client = null;
    
        // If lead_id is provided, get the corresponding lead
        if ($leadId) {
            $lead = \App\Models\Lead::find($leadId);
            if (!$lead) {
                Flash::error('Lead not found');
            }
        }
    
        // If client_id is provided, get the corresponding client
        if ($clientId) {
            $client = \App\Models\Client::find($clientId);
            if (!$client) {
                Flash::error('Client not found');
            }
        }
    
        // Fetch all clients for potential use in the form
        $clients = \App\Models\Client::all();
    
        return view('interactions.create', compact('lead', 'client', 'clients'));
    }
    

    /**
     * Store a newly created Interaction in storage.
     */
    public function store(CreateInteractionRequest $request)
    {
        // Validate the required inputs
        $request->validate([
            'lead_full_name' => 'required|string|max:255',
            'type' => 'nullable|in:Lead,Client'
        ]);
    
        // Retrieve full input from request
        $input = $request->all();
    
        // Check if a lead with this name already exists, otherwise create a new one
        $lead = \App\Models\Lead::firstOrCreate([
            'full_name' => $input['lead_full_name']
        ]);
    
        // Link this interaction to the correct lead
        $input['lead_id'] = $lead->id;
    
        // If 'type' is not provided in the request, determine it dynamically
        if (!isset($input['type'])) {
            $input['type'] = $request->has('client_id') ? 'Client' : 'Lead';
        }
    
        // Create the interaction
        $interaction = $this->interactionRepository->create($input);
    
        Flash::success('Interaction saved successfully.');
    
        return redirect(route('interactions.index'));
    }
    

    /**
     * Display the specified Interaction.
     */
    /**
 * Display all interactions for a specific Lead.
 */
public function show($id)
{
    // Find the lead by its ID
    $lead = Lead::findOrFail($id);

    // Fetch the most recent interaction for this lead
    $currentInteraction = Interaction::where('lead_id', $lead->id)
        ->orderBy('created_at', 'desc')
        ->first(); // This is the latest interaction

    // Fetch all interactions for the lead, ordered by creation date
    $interactions = Interaction::where('lead_id', $lead->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('interactions.show', compact('lead', 'currentInteraction', 'interactions'));
}



    /**
     * Show the form for editing the specified Interaction.
     */
    public function edit($id)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        return view('interactions.edit')->with('interaction', $interaction);
    }

    /**
     * Update the specified Interaction in storage.
     */
    public function update($id, UpdateInteractionRequest $request)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        $interaction = $this->interactionRepository->update($request->all(), $id);

        Flash::success('Interaction updated successfully.');

        return redirect(route('interactions.index'));
    }

    /**
     * Remove the specified Interaction from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        $this->interactionRepository->delete($id);

        Flash::success('Interaction deleted successfully.');

        return redirect(route('interactions.index'));
    }
}
