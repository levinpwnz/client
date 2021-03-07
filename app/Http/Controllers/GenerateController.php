<?php


namespace App\Http\Controllers;


use App\Jobs\sendTransactionToBank;
use App\Transaction;
use Illuminate\Http\RedirectResponse;

class GenerateController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function generateJobs(): RedirectResponse
    {
        // $numberOfTransactions = random_int(1, 20);
        $numberOfTransactions = 1;

        for ($i = 0; $i < $numberOfTransactions; ++$i) {
            dispatch((new sendTransactionToBank($this->makeTransaction())));
        }

        return back()->with(['message' => \sprintf("Транзакций отправлено: %d", $numberOfTransactions)]);
    }

    private function makeTransaction(): Transaction
    {

        return (new Transaction())
            ->setTransactionId(random_int(1, 1000))
            ->setOrderNumber(random_int(1, 1000))
            ->setSum(random_int(10, 500))
            ->setCommissionFee(random_int(5, 20) / 10);

    }
}
