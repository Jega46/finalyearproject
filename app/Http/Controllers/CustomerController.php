<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->where('company_id', auth()->user()->company_id);
        if (!empty($_REQUEST['s'])) {
            $customers->where('name', 'like', "%" . $_REQUEST['s'] . "%")->orWhere('email', 'like', "%" . $_REQUEST['s'] . "%")->orWhere('mobile', 'like', "%" . $_REQUEST['s'] . "%")->orWhere
                ->orWhere('company_name', 'like', "%" . $_REQUEST['s'] . "%")->orWhere('gstin', 'like', "%" . $_REQUEST['s'] . "%");
        }
        $customers = $customers->paginate(20);
        return Inertia::render('Customer/Index', ['customers' => $customers]);
    }
    // write store action
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
        ]);
        $customer = Customer::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company_name' => $request->company_name,
            'gstin' => $request->gstin,
            'billing_address' => $request->billing_address,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_pincode' => $request->billing_pincode,
            'billing_country' => $request->billing_country,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_pincode' => $request->shipping_pincode,
            'shipping_country' => $request->shipping_country,
        ]);
        //session flash message
        $request->session()->flash('message', 'Customer created successfully!');
        return Redirect::route('customers.index');
    }
    // write update action
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],

            'mobile' => ['required', 'string', 'max:255'],

        ]);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'company_name' => $request->company_name,
            'gstin' => $request->gstin,
            'billing_address' => $request->billing_address,
            'billing_city' => $request->billing_city,
            'billing_state' => $request->billing_state,
            'billing_pincode' => $request->billing_pincode,
            'billing_country' => $request->billing_country,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_pincode' => $request->shipping_pincode,

            'shipping_country' => $request->shipping_country,
        ]);
        //session flash message
        $request->session()->flash('message', 'Customer updated successfully!');
        return Redirect::route('customers.index');
    }

    // write delete request
    public function destroy(Request $request, Customer $customer)
    {
        $customer->delete();
        //session flash message
        $request->session()->flash('message', 'Customer deleted successfully!');
        return Redirect::route('customers.index');
    }
}
