<?php
namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerById($customerId)
    {
        return Customer::findOrFail($customerId);
    }

    public function createCustomer($data)
    {
        return Customer::create($data);
    }

    public function updateCustomer($customerId, $data)
    {
        $customer = $this->getCustomerById($customerId);
        $customer->update($data);

        return $customer;
    }

    public function deleteCustomer($customerId)
    {
        $customer = $this->getCustomerById($customerId);
        $customer->delete();

        return $customer;
    }

    
}
