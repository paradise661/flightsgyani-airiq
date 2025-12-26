<?php

namespace App\Http\Services;

use App\Models\Vendor;
use Yajra\Datatables\Datatables;

class VendorService
{

    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function create($attr)
    {
        return $this->vendor->create($attr);
    }

    public function findBy($id)
    {
        return $this->vendor->find($id);
    }

    public function update($request)
    {
        return $this->vendor->update($request);
    }

    public function getTableData()
    {
        $query = $this->getAll();
        return Datatables::of($query)->addColumn('actions', '')->make(true);
    }

    public function getAll()
    {
        return $this->vendor->all();
    }

}
