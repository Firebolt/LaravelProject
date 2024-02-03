<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;

class CustumerCotnroller extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return view('customers.index', compact('customers'));
    }

    public function show($customerId)
    {
        $customer = $this->customerService->getCustomerById($customerId);
        return view('customers.show', compact('customer'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $this->customerService->createCustomer($data);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit($customerId)
    {
        $customer = $this->customerService->getCustomerById($customerId);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $customerId)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $this->customerService->updateCustomer($customerId, $data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($customerId)
    {
        $this->customerService->deleteCustomer($customerId);

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

}
