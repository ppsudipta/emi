<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class EMIService
{
    /**
     * Process all loans and generate EMI table.
     */
    public function process(): array
    {
        $loans = DB::table('loan_details')->orderBy('clientid')->get();

        if ($loans->isEmpty()) {
            return ['months' => [], 'data' => collect()];
        }

        // Determine all months between first and last payments
        $firstDate = DB::table('loan_details')->min('first_payment_date');
        $lastDate  = DB::table('loan_details')->max('last_payment_date');

        $start = Carbon::parse($firstDate)->startOfMonth();
        $end   = Carbon::parse($lastDate)->startOfMonth();

        $months = [];
        $cursor = $start->copy();
        while ($cursor <= $end) {
            $months[] = $cursor->format('Y_M');
            $cursor->addMonth();
        }

        // Drop old table if exists
        DB::statement('DROP TABLE IF EXISTS emi_details');

        // Create table dynamically
        $colsSql = ['`clientid` INT NOT NULL'];
        foreach ($months as $m) {
            $colsSql[] = "`$m` DECIMAL(14,2) DEFAULT 0.00";
        }
        $colsSql[] = 'PRIMARY KEY (`clientid`)';

        $createSql = 'CREATE TABLE `emi_details` (' . implode(',', $colsSql) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
        DB::statement($createSql);

        // Start transaction
        DB::beginTransaction();
        try {
            foreach ($loans as $loan) {

                $row = ['clientid' => $loan->clientid];

                $first = Carbon::parse($loan->first_payment_date)->startOfMonth();
                $last  = Carbon::parse($loan->last_payment_date)->startOfMonth();

                // All months in loan period
                $loanMonths = [];
                $cursorLoan = $first->copy();
                while ($cursorLoan <= $last) {
                    $loanMonths[] = $cursorLoan->format('Y_M');
                    $cursorLoan->addMonth();
                }

                $numMonths = count($loanMonths);
                if ($numMonths === 0) continue;

                // Calculate base EMI
                $totalLoan = $loan->loan_amount;
                $baseEmi = round(($totalLoan / $numMonths) * 100) / 100; // round down to 2 decimals
                $totalAssigned = $baseEmi * ($numMonths - 1);

                foreach ($months as $m) {
                    if (in_array($m, $loanMonths)) {
                        // Last month of loan gets remainder
                        if ($m === end($loanMonths)) {
                            $row[$m] = round($totalLoan - $totalAssigned, 2);
                        } else {
                            $row[$m] = $baseEmi;
                        }
                    } else {
                        $row[$m] = 0.00;
                    }
                }

                // Insert row
                $colsBackticked = implode(',', array_keys($row));
                $valuesSql = implode(',', array_map(fn($v) => is_numeric($v) ? $v : "'$v'", array_values($row)));
                $insertSql = "INSERT INTO `emi_details` ($colsBackticked) VALUES ($valuesSql);";
                DB::statement($insertSql);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // Return structured results for Blade
        $emiData = DB::table('emi_details')->orderBy('clientid')->get();
        return [
            'months' => $months,
            'data'   => $emiData,
        ];
    }

    
   
}
