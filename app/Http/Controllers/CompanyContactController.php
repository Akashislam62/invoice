<?php

namespace App\Http\Controllers;

use App\Models\CompanyContact;
use App\Models\CompanyInfo;
use Illuminate\Support\Facades\Log;
use e;
use Exception;
use Illuminate\Http\Request;

class CompanyContactController extends Controller
{
    public function IndexcompanyContact()
    {
        $companyInfo = CompanyInfo::all();
        return (view('frontend.contact.index',compact('companyInfo')));

        // return view('frontend.contact.index');
    }

    public function ListCompanyContact()
    {
        // $listCompanyInfo = CompanyInfo::all();
        // $listCompanyInfo = CompanyInfo::paginate(4); 
        $listCompanyContact = CompanyContact::orderBy('created_at', 'desc')->paginate(5);
        return view('frontend.contact.list', compact('listCompanyContact'));
    }

    public function editCompanyContact($id)
    {
        $editCompanyInfo = CompanyContact::findOrFail($id);
        return view('frontend.contact.edit', compact('editCompanyInfo'));
    }



    public function createCompanyContact(Request $request)
    {
        try {
            // Create record
            CompanyContact::create([
                'name' => $request->input('name'),
                'address' => $request->input('designation'),
                'email' => $request->input('email_id'),
                'phone' => $request->input('contact_number'),
                'website' => $request->input('email_id')
            ]);
            return response()->json(['status' => 'success']);

        }
        catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->withInput()->withErrors(['error' => 'input field is required. please try again.']);
        }
    }



    public function updateCompanyContact(Request $request, $id)
    {
        try {
            //error message validation
            // Find the company by ID & Check if the email already exists for another company
            $company = CompanyContact::findOrFail($id);
            $emailExists = CompanyContact::where('email', $request->email)->where('id', '!=', $id)->exists();
            if ($emailExists) {
                return response()->json([
                    'status' => 'failed',
                    'email' => 'Email already exists.'
                ]);
            }
    
            // Update the company information
            $company->name = $request->name;
            $company->address = $request->address;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->website = $request->website;
            $company->description = $request->description;
            $company->save();
    
            return response()->json(['status' => 'success', 'message' => 'Company information updated successfully.']);
    
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['status' => 'failed', 'message' => 'An error occurred. Please try again.']);
        }
    }
    

    public function deleteCompanyContact($id)
    {
        try {
            $companyInfo = CompanyContact::findOrFail($id)->delete();
            return response()->json(['success' => 'Record deleted successfully.']);

        } 
        catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->withInput()->withErrors(['error' => 'foreign key related. please try again.']);
        }
    }

}
