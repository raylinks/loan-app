<?php

namespace App\Traits;

use App\Models\Transaction;

trait HasWalletFunctionalities
{
    /**
     * Create wallet histories.
     *
     * @param \App\Models\WalletTransaction $transaction
     * @param string|null $currencyCode
     *
     * @return mixed
     */
    public function createHistory(Transaction $transaction, string $currencyCode = null)
    {
        $type = $this->current_balance > $this->initial_balance
            ? Transaction::WALLET_ACTIONS['CREDIT']
            : Transaction::WALLET_ACTIONS['DEBIT'];

        $amount = abs($this->current_balance - $this->initial_balance);

        $data = [
            'type' => $type,
            'amount' => $amount,
            'transaction_id' => $transaction->id,
            'current_amount' => $this->current_balance,
            'previous_amount' => $this->initial_balance,
        ];

        $data = $currencyCode ? array_merge(['currency' => $currencyCode], $data) : $data;

        return $this->histories()->create($data);
    }

    /**
     * Debits a specified amount from wallet's balances.
     *
     * @param float $amount Amount to be debited.
     *
     * @return void
     */
    public function debit(float $amount): void
    {
        $this->confirmSufficientBalance($amount);

        $this->initial_balance = $this->book_balance;
        $this->book_balance -= $amount;
        $this->current_balance -= $amount;

        $this->save();
    }

    /**
     * Debits a specified amount from a wallet's available balance while transaction is processing/pending.
     *
     * @param float $amount
     *
     * @return void
     */
    public function initiateDebit(float $amount): void
    {
        $this->confirmSufficientBalance($amount);

        $this->current_balance -= $amount;
        $this->save();
    }

    /**
     * Debits specified amount from wallet's book balance when transaction is deemed to be successful/confirmed.
     *
     * @param float $amount
     *
     * @return void
     */
    public function finalizeDebit(float $amount): void
    {
        $this->initial_balance = $this->book_balance;
        $this->book_balance -= $amount;

        $this->save();
    }

    /**
     * Credits a specified amount to a wallet's balances.
     *
     * @param float $amount
     *
     * @return void
     */
    public function credit(float $amount): void
    {
        $this->initial_balance = $this->current_balance;
        $this->book_balance += $amount;
        $this->current_balance += $amount;

        $this->save();
    }

    /**
     * Credits specified amount to wallet's book balance when transaction is pending/processing.
     *
     * @param float $amount
     *
     * @return void
     */
    public function initiateCredit(float $amount): void
    {
        $this->book_balance += $amount;
        $this->save();
    }

    /**
     * Credits specified amount to wallet's available balance when transaction is deemed successful.
     *
     * @param float $amount
     *
     * @return void
     */
    public function finalizeCredit(float $amount): void
    {
        $this->initial_balance = $this->current_balance;
        $this->current_balance += $amount;

        $this->save();
    }

    private function confirmSufficientBalance(float $amount): void
    {
        if ($this->current_balance < $amount || $amount < 0) {
            abort("Wallet could not be debited: amount specified is greater than wallet's available balance");
        }
    }
}
