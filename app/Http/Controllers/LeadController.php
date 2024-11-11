<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Repositories\ClientRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LeadRepository;
use App\Models\Employee; 
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Client;
use Flash;

class LeadController extends AppBaseController
{
    /** @var LeadRepository $leadRepository*/
    private $leadRepository;

    private $clientRepository;

    public function __construct(LeadRepository $leadRepo, ClientRepository $clientRepo)
    {
        $this->leadRepository = $leadRepo;
        $this->clientRepository = $clientRepo; // Inject the ClientRepository
    }
    /**
     * Display a listing of the Lead.
     */
// In your controller
// In your controller
public function index()
{
    $leads = Lead::with('employee')->paginate(10);
    return view('leads.index', compact('leads'));
}

    /**
     * Show the form for creating a new Lead.
     */
    public function create()
    {
        $employees = Employee::all();  // Get all employees
    
        return view('leads.create', compact('employees'));  // Pass employees to the view
    }

    /**
     * Store a newly created Lead in storage.
     */
    public function store(CreateLeadRequest $request)
    {
        $input = $request->all();

        $lead = $this->leadRepository->create($input);

        Flash::success('Lead saved successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Display the specified Lead.
     */
    public function show($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');

            return redirect(route('leads.index'));
        }

        return view('leads.show')->with('lead', $lead);
    }

    /**
     * Show the form for editing the specified Lead.
     */
    public function edit($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');

            return redirect(route('leads.index'));
        }

        return view('leads.edit')->with('lead', $lead);
    }

    /**
     * Update the specified Lead in storage.
     */
    public function update($id, UpdateLeadRequest $request)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');

            return redirect(route('leads.index'));
        }

        $lead = $this->leadRepository->update($request->all(), $id);

        Flash::success('Lead updated successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Remove the specified Lead from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');

            return redirect(route('leads.index'));
        }

        $this->leadRepository->delete($id);

        Flash::success('Lead deleted successfully.');

        return redirect(route('leads.index'));
    }
}
