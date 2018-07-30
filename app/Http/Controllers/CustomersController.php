<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;

class CustomersController extends Controller
{
    public function __construct(CustomerService $customer_service)
    {
        $this->service = $customer_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = $this->service->paginated();
        return view('customers.index')->with('customers', $customers);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $customers = $this->service->search($request->search);
        return view('customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CustomerCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerCreateRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(route('customers.edit', ['id' => $result->id]))->with('message', 'Successfully created');
        }

        return redirect(route('customers.index'))->withErrors('Failed to create');
    }

    /**
     * Display the customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->service->find($id);
        return view('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = $this->service->find($id);
        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the customers in storage.
     *
     * @param  App\Http\Requests\CustomerUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        $result = $this->service->update($id, $request->except('_token'));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->withErrors('Failed to update');
    }

    /**
     * Remove the customers from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect(route('customers.index'))->with('message', 'Successfully deleted');
        }

        return redirect(route('customers.index'))->withErrors('Failed to delete');
    }
}
