<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInteractionRequest;
use App\Http\Requests\UpdateInteractionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InteractionRepository;
use Illuminate\Http\Request;
use App\Models\Interaction;
use App\Models\Client;  // Correct import at the top
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
        
        // Query interactions with related client and lead models
        $interactions = Interaction::with(['client', 'lead'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    // Search in the 'interactions' table itself
                    $subQuery->where('type', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%')
                             ->orWhere('interactions_date', 'like', '%' . $search . '%')
                             
                             // Search in the related 'client' table
                             ->orWhereHas('client', function ($query) use ($search) {
                                 $query->where('first_name', 'like', '%' . $search . '%')
                                       ->orWhere('last_name', 'like', '%' . $search . '%')
                                       ->orWhere('company_name', 'like', '%' . $search . '%')
                                       ->orWhere('email_address', 'like', '%' . $search . '%');
                             })
                             
                             // Search in the related 'lead' table
                             ->orWhereHas('lead', function ($query) use ($search) {
                                 $query->where('full_name', 'like', '%' . $search . '%')
                                       ->orWhere('email', 'like', '%' . $search . '%');
                             });
                });
            })
            ->paginate(10);
        
        return view('interactions.index', compact('interactions'));
    }
    

    /**
     * Show the form for creating a new Interaction.
     */
    public function create(Request $request)
    {
        // retrieve lead id from the query string
        $leadId = $request->query('lead_id');

        if ($leadId) {
            $lead = \App\Models\Lead::find($leadId); // find lead with specific lead id
            if (!$lead) {
                Flash::error('Interaction not found');
            }
            Flash::success('Interaction saved successfully.'); 
        }

        $clients = Client::all();
        return view('interactions.create', compact('lead', 'clients')); 
    }

    /**
     * Store a newly created Interaction in storage.
     */
    public function store(CreateInteractionRequest $request)
    {
        // validate the required inputs
        $request->validate([
            'lead_full_name' => 'required|string|max:255'
        ]);
        // retrieve full input from request
        $input = $request->all();
        // check if a lead with this name already exists, otherwise create a new one
        $lead = \App\Models\Lead::firstOrCreate([
            'full_name' => $input['lead_full_name']
        ]);

        // Link this interaction to the correct lead
        $input['lead_id'] = $lead->id;

        $interaction = $this->interactionRepository->create($input);

        Flash::success('Interaction saved successfully.');

        return redirect(route('interactions.index'));
    }

    /**
     * Display the specified Interaction.
     */
    public function show($id)
    {
        $interaction = $this->interactionRepository->find($id);

        if (empty($interaction)) {
            Flash::error('Interaction not found');

            return redirect(route('interactions.index'));
        }

        return view('interactions.show')->with('interaction', $interaction);
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
