<?php

namespace App\Jobs;

use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class sendTransactionToBank implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * Create a new job instance.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $transaction = \App\Models\Transaction::create([
            'transaction_id' => $this->transaction->transaction_id,
            'sum' => $this->transaction->sum,
            'commission_fee' => $this->transaction->commissionFee,
            'order_id' => $this->transaction->orderNumber
        ]);


        try {
            $r = Http::post('http://bank.local/api/v1/transaction', [
                'transaction' => $transaction->toArray(),
                'hash' => $hash = $this->calculateHash($transaction->toArray())
            ]);

            Log::debug('Transaction sent successfully', ['data' => [
                'transaction' => $transaction->toArray(),
                'hash' => $hash,
                'bank_response' => $r->json()
            ]]);

        } catch (\Exception $exception) {
            Log::alert(sprintf('Remote server error code: %d, message: %s',
                $exception->getCode(),
                $exception->getMessage()));
        }
    }


    private function calculateHash(array $data): string
    {
        $hash = '';

        foreach ($data as $key => $item) {
            $hash .= $key . $item;
        }

        return md5($hash);
    }
}
