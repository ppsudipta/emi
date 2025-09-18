<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\LoanRepository;
use App\Services\EMIService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $emiService;
    protected $loanRepository;

    /**
     * AdminController constructor.
     * 
     * @param EMIService $emiservice
     * @param LoanRepository $loanRepository
     * 
     * @return void
     */
    public function __construct(EMIService $emiservice, LoanRepository $loanRepository)
    {
        $this->emiService = $emiservice;
        $this->loanRepository = $loanRepository;
    }

    /**
     * Display a listing of loan details.
     */
    public function index()
    {
        $loanDetails = $this->loanRepository->getAll();
        return view('admin.loan_details', compact('loanDetails'));
    }


    /**
     * Process all loans and open the EMI processing page.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $emiResults = ['months' => [], 'data' => collect()];
        return view('admin.process');
    }

    /**
     * Process all loans and generate EMI table.
     * 
     * @return \Illuminate\View\View
     */
   public function processData()
    {
        try {
          

              // 1️⃣ Calculate EMIs using the service
        $this->emiService->process();

        // 2️⃣ Read structured EMI data from repository
        $emiResults = $this->loanRepository->getEmiTable(); 

            // Ensure result structure for Blade view
            $emiResults = [
                'months' => $emiResults['months'] ?? [],
                'data'   => $emiResults['data'] ?? collect(),
            ];

            // 2️⃣ Return the view with processed EMI results
            return view('admin.process', compact('emiResults'))
                ->with('success', 'EMI processed successfully.');

        } catch (\Exception $e) {
            // 3️⃣ Handle errors gracefully
            \Log::error('EMI processing failed: '.$e->getMessage());

            return redirect()->back()
                         ->with('error', 'Failed to process EMI.');
    }

    }

}
