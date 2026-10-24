<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository
{
    public function getAll(array $fields)
    {
        return Doctor::select($fields)->latest()->with(['hospital', 'specialist'])->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Doctor::select($fields)->with(['hospital', 'specialist', 'bookingTransactions.user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Doctor::create($data);
    }
}
