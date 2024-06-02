<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class CompanyInfoController extends Controller
{
    public function indexCompanyInfo()
    {
        return view('frontend.company_info.index');
    }

    public function listCompanyInfo()
    {
        // $listCompanyInfo = CompanyInfo::all();
        // $listCompanyInfo = CompanyInfo::paginate(4); 
        $listCompanyInfo = CompanyInfo::orderBy('created_at', 'desc')->paginate(5);
        return view('frontend.company_info.list', compact('listCompanyInfo'));
    }

    public function editCompanyInfo($id)
    {
        $editCompanyInfo = CompanyInfo::findOrFail($id);
        return view('frontend.company_info.edit', compact('editCompanyInfo'));
    }



    public function createCompanyInfo(Request $request)
    {
        try {
            //error message validation
            $info = CompanyInfo::where('email',$request->input('email'))->first();
            if($info){
                return response()->json([
                    'status'=>'failed',
                    'email'=>'Email already exists.'
                ]);
            }

            // Create record
            CompanyInfo::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'website' => $request->input('website'),
                'description' => $request->input('description'),
            ]);
            return response()->json(['status' => 'success']);

        }
        catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->withInput()->withErrors(['error' => 'input field is required. please try again.']);
        }
    }



    public function updateCompanyInfo(Request $request, $id)
    {
        try {
            //error message validation
            // Find the company by ID & Check if the email already exists for another company
            $company = CompanyInfo::findOrFail($id);
            $emailExists = CompanyInfo::where('email', $request->email)->where('id', '!=', $id)->exists();
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
    

    public function deleteCompanyInfo($id)
    {
        try {
            $companyInfo = CompanyInfo::findOrFail($id)->delete();
            return response()->json(['success' => 'Record deleted successfully.']);

        } 
        catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->withInput()->withErrors(['error' => 'foreign key related. please try again.']);
        }
    }

}
