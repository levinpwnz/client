<?php


namespace App\Http\Controllers;


use App\Jobs\sendTransactionToBank;
use App\Transaction;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\Hash;

class GenerateController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateJobs()
    {
        // $numberOfTransactions = random_int(1, 20);
        $numberOfTransactions = 1;

        for ($i = 0; $i < $numberOfTransactions; ++$i) {
            dispatch((new sendTransactionToBank($this->makeTransactions())));
        }

        return back()->with(['message' => "Транзакций отправлено: $numberOfTransactions"]);
    }

    private function makeTransactions(): Transaction
    {

        return (new Transaction())
            ->setTransactionId(random_int(1, 1000))
            ->setOrderNumber(random_int(1, 1000))
            ->setSum(random_int(10, 500))
            ->setCommissionFee(random_int(5, 20) / 10);

    }
}
