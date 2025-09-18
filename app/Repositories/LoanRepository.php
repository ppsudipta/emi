<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\LoanDetail;

class LoanRepository
{
/**
 * Retrieve all loan details, ordered by client ID.
 *
 * @return \Illuminate\Support\Collection|LoanDetail[]
 */
public function getAll()
{
    return LoanDetail::get();
}

  /**
     * Get EMI table for display
     * Returns array with 'months' and 'data'
     */
    public function getEmiTable(): array
    {
        // Get all EMI columns from the table (excluding clientid)
        $columns = DB::getSchemaBuilder()->getColumnListing('emi_details');

       
        // Remove the 'clientid' column
        $months = array_filter($columns, fn($col) => $col !== 'clientid');

        // Get EMI data
        $data = DB::table('emi_details')->orderBy('clientid')->get();

        return [
            'months' => $months,
            'data'   => $data,
        ];
    }

}