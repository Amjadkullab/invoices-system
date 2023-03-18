<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices =  invoices::onlyTrashed()->get();
        return view('invoices.Archive_Invoice',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = $request->invoice_id;
         $flight = Invoices::withTrashed()->where('id', $id)->restore();
         session()->flash('restore_invoice');
         return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
          // return $request;
          $id = $request->invoice_id;
          $invoice = invoices::onlyTrashed()->where('id', $id)->first();
          // return $invoice;
          $details = invoice_attachments::where('invoice_id', $id)->get();

          foreach ($details as $detail) {
              if (!empty($detail->invoice_number)) {
                  Storage::disk('public_uploads')->delete($detail->invoice_number . "/" . $detail->file_name);
              }
          }

          $invoice->forceDelete();
          session()->flash('delete_invoice');
          return redirect('/invoices');
      }
    }


