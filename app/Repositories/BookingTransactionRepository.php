<?php

namespace App\Repositories;

use App\Models\BookingTransaction;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingTransactionRepository
{
    // manager queries
    public function getAll(): LengthAwarePaginator
    {
        return BookingTransaction::with(['doctor', 'doctor.hospital', 'doctor.specialist', 'doctor.specialist', 'user'])->latest()->paginate(10);
    }

    public function getByIdForManager(int $id): ?BookingTransaction
    {
        return BookingTransaction::with(['doctor', 'doctor.hospital', 'doctor.specialist', 'user'])->findOrFail($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $transaction = $this->getByIdForManager($id);
        $transaction->update(['status' => $status]);
        return $transaction;
    }

    // customer queries
    public function getAllForUser(int $userId): LengthAwarePaginator
    {
        return BookingTransaction::where('user_id', $userId)->with(['doctor', 'doctor.hospital', 'doctor.specialist'])->latest()->paginate(10);
    }

    public function getById(int $id, int $userId): ?BookingTransaction
    {
        return BookingTransaction::where('id', $id)->where('user_id', $userId)->with(['doctor', 'doctor.hospital', 'doctor.specialist'])->firstOrFail();
    }

    public function create(array $data)
    {
        return BookingTransaction::create($data);
    }

    public function isTimelotTakenForDoctor(int $doctorId, string $date, string $time)
    {
        return BookingTransaction::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('time', $time)
            ->exists();
    }
}
