<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name','like',"%{$search}%")
                  ->orWhere('email','like',"%{$search}%");
            });
        }
        $customers = $query->orderBy('created_at','desc')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles','public');
            $data['profile_image'] = $path;
        }
        Customer::create($data);
        return redirect()->route('customers.index')->with('success','Customer added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();
        if ($request->hasFile('profile_image')) {
            // delete old if exists
            if ($customer->profile_image) Storage::disk('public')->delete($customer->profile_image);
            $data['profile_image'] = $request->file('profile_image')->store('profiles','public');
        }
        $customer->update($data);
        return redirect()->route('customers.index')->with('success','Customer updated');
    }

    /**
     * Remove (soft delete) the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete(); // soft delete
        return redirect()->route('customers.index')->with('success','Customer deleted');
    }

    /**
     * Display trashed (soft-deleted) customers
     */
    public function trashed(Request $request)
    {
        $customers = Customer::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('customers.trashed', compact('customers'));
    }

    /**
     * Restore a soft-deleted customer
     */
    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();
        return redirect()->route('customers.index')->with('success', 'Customer restored successfully');
    }

    /**
     * Permanently delete a soft-deleted customer
     */
    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        
        // Delete profile image if exists
        if ($customer->profile_image) {
            Storage::disk('public')->delete($customer->profile_image);
        }
        
        $customer->forceDelete();
        return redirect()->route('customers.trashed')->with('success', 'Customer permanently removed');
    }

    /**
     * Export customers to CSV
     */
    public function exportCsv()
    {
        $fileName = 'customers_'.date('Ymd_His').'.csv';
        $customers = Customer::all();
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];
        $columns = ['id','name','email','phone','address','created_at'];
        $callback = function() use($customers,$columns) {
            $file = fopen('php://output','w');
            fputcsv($file, $columns);
            foreach($customers as $c) {
                fputcsv($file, [$c->id,$c->name,$c->email,$c->phone,$c->address,$c->created_at]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export customers to PDF
     */
    public function exportPdf()
    {
        $customers = Customer::all();
        $pdf = \PDF::loadView('customers.pdf', compact('customers'));
        return $pdf->download('customers_'.date('Ymd_His').'.pdf');
    }

    /**
     * AJAX search endpoint - returns partial table
     */
    public function ajaxSearch(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Customer::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->orderBy('created_at', 'desc')->get();
        
        return view('customers._table', compact('customers'));
    }
}
