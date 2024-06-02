
@extends('frontend.layout.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Tables</h6>
            <button class="float-right btn btn-primary" id="add-company-info-btn">Add CompanyInfo</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Website</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($listCompanyInfo as $companyInfo)
                            <tr>
                                <td>{{ $companyInfo->name }}</td>
                                <td>{{ $companyInfo->address }}</td>
                                <td>{{ $companyInfo->email }}</td>
                                <td>{{ $companyInfo->phone }}</td>
                                <td>{{ $companyInfo->website }}</td>
                                <td>{{ $companyInfo->description }}</td>
                                <td>
                                    <a href="{{ url('/company-info/edit/' . $companyInfo->id) }}" style="text-decoration:none">
                                        <button class="btn btn-success">Edit</button>
                                    </a>

                                    <a href="{{ route('company-info.delete', $companyInfo->id) }}" onclick="deleteConfirmation(event)">
                                        <button class="btn btn-danger">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    

    <script type="text/javascript">

        //Add CompanyInfo button click
        document.getElementById('add-company-info-btn').addEventListener('click', function() {
            window.location.href="/company-info";
        });

        //Delete er code
        function deleteConfirmation(event) {
            event.preventDefault();
            var urlToRedirect = event.currentTarget.getAttribute('href');
            
            swal({
                title: "Are you sure you want to delete?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })

            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(urlToRedirect, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            swal("Deleted!", "The record has been deleted.", "success")
                            .then(() => {
                                // Optionally, reload the page or redirect
                                location.reload();
                            });
                        } else {
                            swal("Error!", "There was an error deleting the record.", "error");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        swal("Error!", "There was an error deleting the record.", "error");
                    });
                }
            });
        }


        
    </script>


@endsection

























@extends('frontend.layout.app')
@section('content')

    <div class="container-fluid">
        <div class="antialiased">
            <form id="company-info-form">
                
                <div class="form-group">

                    <label for="name">Name <span class="text-danger p-0 mb-4 d-none" id="name-error"> * Required</span> </label><br>
                    <input type="text" class="form-control" id="name" name="name"><br>

                    <label for="address">Address</label><br>
                    <input type="text" class="form-control" id="address" name="address" ><br>

                    <label for="email">Email <span class="text-danger p-0 mb-4 d-none" id="email-error"> * Required</span> </label><br>
                    <input type="email" class="form-control" id="email" name="email"><br>

                    <label for="phone">Phone</label><br>
                    <input type="text" class="form-control" id="phone" name="phone"><br>

                    <label for="website">Website</label><br>
                    <input type="text" class="form-control" id="website" name="website"><br>

                    <label for="description">Description</label><br>
                    <textarea class="form-control" id="description" name="description"></textarea><br>

                    <button type="button" class="btn btn-primary" id="submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
<script>
    $().ready(function(){
        console.log('hghgh')
        $('#submit-btn').on('click', async function(e){
            e.preventDefault();

            let name = $('#name').val();
            let address = $('#address').val();
            let email = $('#email').val();
            let phone = $('#phone').val();
            let website = $('#website').val();
            let description = $('#description').val();
            //console.log(name, address, email, phone, website, description);

            //validation
            //console.log(name.length)
            if(name.length===0){
                $('#name-error').removeClass('d-none');
                $('#name').focus();
                // alert('Name is requered');
                return
            }
            else if(email.length===0){
                $('#email-error').removeClass('d-none');
                $('#email').focus();
                return
            }
            
            let companyFormData = {
                name:name,
                address:address,
                email:email,
                phone:phone,
                website:website,
                description:description
            }

            let URL = "/company-info/create";
            let result = await axios.post(URL,companyFormData)
            if(result.status===200 && result.data.status === 'success'){
                //console.log(result)
                // alert('Your request has been submitted successfully')
                window.location.href = '/company-info/list';
            }
            else{
                alert('Something went wrong')
            }
            
        })
    });
</script>
@endsection
























@extends('frontend.layout.app')
@section('content')

<div class="container-fluid">
    <div class="antialiased">
        <form id="company-info-form">
            
            <div class="form-group">
                <label for="update_name">Name <span class="text-danger p-0 mb-4 d-none" id="name-error"></span> </label><br>
                <input type="text" class="form-control" id="update_name" name="update_name"><br>

                <label for="update_address">Address</label><br>
                <input type="text" class="form-control" id="update_address" name="update_address" ><br>

                <label for="update_email">Email <span class="text-danger p-0 mb-4 d-none" id="email-error"></span></label><br>
                <input type="email" class="form-control" id="update_email" name="update_email"><br>

                <label for="update_phone">Phone</label><br>
                <input type="text" class="form-control" id="update_phone" name="update_phone"><br>

                <label for="update_website">Website</label><br>
                <input type="text" class="form-control" id="update_website" name="update_website"><br>

                <label for="update_description">Description</label><br>
                <textarea class="form-control" id="update_description" name="update_description"></textarea><br>

                <button type="button" class="btn btn-primary" id="submit-btn">Submit</button>
            </div>
        </form>
    </div>
</div>




@endsection































<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class CompanyInfoController extends Controller
{
    public function indexCompanyInfo()
    {
        return view('frontend.company_info.index');
    }

    public function listCompanyInfo()
    {
        $listCompanyInfo = CompanyInfo::all(); 
        return view('frontend.company_info.list', compact('listCompanyInfo'));
    }

    // public function editCompanyInfo(Request $request)
    // {
    //     $editCompanyInfo = CompanyInfo::find($request->id);
    //     return view('frontend.company_info.edit', compact('editCompanyInfo'));
    // }
    public function editCompanyInfo($id)
    {
        $editCompanyInfo = CompanyInfo::findOrFail($id);
        return view('frontend.company_info.edit', compact('editCompanyInfo'));
    }



    public function createCompanyInfo(Request $request)
    {
        try {
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
            

        } catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->withInput()->withErrors(['error' => 'input field is required. please try again.']);
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




    // public function updateCompanyInfo(Request $request)
    // {
    //     try {

    //         $companyInfoId = $request->id;

    //         // Update CompanyInfo
    //         $result = CompanyInfo::where('id', $companyInfoId)->update([
    //             'name_id' => $request->input('update_name'),
    //             'address_id' => $request->input('update_address'),
    //             'email_id' => $request->input('update_email'),
    //             'phone_id' => $request->input('update_phone'),
    //             'website_id' => $request->input('update_website'),
    //             'description_id' => $request->input('update_description')
    //         ]);
    //         return redirect('/company-info/list')->with('success', 'updated successful!');
           
    //     }catch (\Exception $exception) {
    //         Log::error($exception);
    //         return redirect()->back()->withInput()->withErrors(['error' => 'dropdown menu selected. please try again.']);
    //     }
    // }


    public function updateCompanyInfo(Request $request, $id)
    {
        try {
            $companyInfo = CompanyInfo::findOrFail($id);
            $companyInfo->update([
                'name' => $request->input('update_name'),
                'address' => $request->input('update_address'),
                'email' => $request->input('update_email'),
                'phone' => $request->input('update_phone'),
                'website' => $request->input('update_website'),
                'description' => $request->input('update_description')
            ]);

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json(['success' => false, 'error' => $exception->getMessage()], 500);
        }
    }



}











@extends('frontend.layout.app')
@section('content')

    <div class="row">

        <!-- left column -->
        <div class="col-md-12">

            <div class="card card-gray">

                <div class="card-header">
                    <a href="{{ url('/company-info/list') }}" class="mb-4 inline-block" id="iconLink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-skip-backward-circle float-left" viewBox="0 0 16 16" style="margin-right: 20px;" data-toggle="tooltip" data-placement="left" title="Back List">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M11.729 5.055a.5.5 0 0 0-.52.038L8.5 7.028V5.5a.5.5 0 0 0-.79-.407L5 7.028V5.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0V8.972l2.71 1.935a.5.5 0 0 0 .79-.407V8.972l2.71 1.935A.5.5 0 0 0 12 10.5v-5a.5.5 0 0 0-.271-.445"/>
                        </svg>
                    </a>
                    <h3 class="card-title">Companies</h3>
                </div>

                
            
                <!-- form start -->
                <form id="company-info-form">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name">Name <span class="text-danger p-0 mb-4 d-none" id="name-error"> * Required</span> </label><br>
                            <input type="text" class="form-control" id="name" name="name"><br>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label><br>
                            <input type="text" class="form-control" id="address" name="address" ><br>
                        </div>

                        
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger p-0 mb-4 d-none" id="email-error"> * Required</span> </label><br>
                                    <input type="email" class="form-control" id="email" name="email"><br>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label><br>
                                    <input type="text" class="form-control" id="phone" name="phone"><br>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="website">Website</label><br>
                                    <input type="text" class="form-control" id="website" name="website"><br>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea type="textarea" name="description" placeholder="Description" class="form-control" id="description"></textarea>
                                </div>
                            </div>

                        </div>


                        <button type="button" class="btn btn-primary" id="submit-btn">Submit</button>

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection


@section('script')
<script>
    $().ready(function(){
        // console.log('hghgh')
        $('#submit-btn').on('click', async function(e){
            e.preventDefault();

            let name = $('#name').val();
            let address = $('#address').val();
            let email = $('#email').val();
            let phone = $('#phone').val();
            let website = $('#website').val();
            let description = $('#description').val();
            //console.log(name, address, email, phone, website, description);

            //validation
            //console.log(name.length)
            if(name.length===0){
                $('#name-error').removeClass('d-none');
                $('#name').focus();
                // alert('Name is requered');
                return
            }
            else if(email.length===0){
                $('#email-error').removeClass('d-none');
                $('#email').focus();
                return
            }
            
            let companyFormData = {
                name:name,
                address:address,
                email:email,
                phone:phone,
                website:website,
                description:description
            }

            let URL = "/company-info/create";
            let result = await axios.post(URL,companyFormData)
            if(result.status===200 && result.data.status === 'success'){
                //console.log(result)
                // alert('Your request has been submitted successfully')
                window.location.href = '/company-info/list';
            }
            else{
                alert('Something went wrong')
            }
            
        })
    });
</script>

@endsection










@extends('frontend.layout.app')
@section('content')

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">
            Company List
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="gray" class="bi bi-plus-square" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Add" id="add-company-info-svg">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </h6>
        </div>

        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Website</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($listCompanyInfo as $companyInfo)
                            <tr>
                                <td>{{ $companyInfo->name }}</td>
                                <td>{{ $companyInfo->address }}</td>
                                <td>{{ $companyInfo->email }}</td>
                                <td>{{ $companyInfo->phone }}</td>
                                <td>{{ $companyInfo->website }}</td>
                                <td>{{ $companyInfo->description }}</td>
                                <td>
                                    
                                    <a href="{{ url('/company-info/edit/' . $companyInfo->id) }}" style="text-decoration:none">
                                        <button class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Edit">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </button>
                                    </a>

                                    <a href="{{ route('company-info.delete', $companyInfo->id) }}" onclick="deleteConfirmation(event)">
                                        <button class="btn btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Delete">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                            </svg>
                                        </button>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        //Add svg button click
        document.getElementById('add-company-info-svg').addEventListener('click', function() {
            window.location.href = "/company-info";
        });

        



        //Delete er code
        function deleteConfirmation(event) {
            event.preventDefault();
            var urlToRedirect = event.currentTarget.getAttribute('href');
            
            swal({
                title: "Are you sure you want to delete?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })

            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(urlToRedirect, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            swal("Deleted!", "The record has been deleted.", "success")
                            .then(() => {
                                // Optionally, reload the page or redirect

                                setTimeout(function() {
                                    window.location.href = '/company-info/list';
                                }, 3000);

                                //laravel toaster message display
                                Command: toastr["success"]("Delete", "Delete Sussessfull")
                                toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                                }

                            });
                        } else {
                            swal("Error!", "There was an error deleting the record.", "error");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        swal("Error!", "There was an error deleting the record.", "error");
                    });
                }
            });
        }


    </script>

@endsection






@extends('frontend.layout.app')
@section('content')

    <div class="card mb-4 shadow pb-3 mr-3 ml-3">

        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">
                Company List
                <a href="{{ url('/company-info') }}" class="mb-4 inline-block" id="add-company-info-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0056b3" class="bi bi-plus-square" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Add" id="add-company-info-svg">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                </a>
            </h5>
        </div>

        <!-- <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">
                Company List
                <a href="{{ url('/company-info') }}" class="mb-4 inline-block" id="add-company-info-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0056b3" class="bi bi-plus-square" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Add">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                </a>
            </h5>
        </div> -->
        

        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Website</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($listCompanyInfo as $companyInfo)
                            <tr>
                                <td>{{ $companyInfo->name }}</td>
                                <td>{{ $companyInfo->address }}</td>
                                <td>{{ $companyInfo->email }}</td>
                                <td>{{ $companyInfo->phone }}</td>
                                <td>{{ $companyInfo->website }}</td>
                                <td>{{ $companyInfo->description }}</td>
                                <td>
                                    
                                    <a href="{{ url('/company-info/edit/' . $companyInfo->id) }}" style="text-decoration:none">
                                        <button class="btn btn-primary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Edit">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </button>
                                    </a>
                                    
                                    <a href="{{ route('company-info.delete', $companyInfo->id) }}" onclick="deleteConfirmation(event)">
                                        <button class="btn btn-danger btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Delete">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                            </svg>
                                        </button>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        //Add svg button click
        document.getElementById('add-company-info-svg').addEventListener('click', function() {
            window.location.href = "/company-info";
        });

        



        //Delete er code
        function deleteConfirmation(event) {
            event.preventDefault();
            var urlToRedirect = event.currentTarget.getAttribute('href');
            
            swal({
                title: "Are you sure you want to delete?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })

            .then((willDelete) => {
                if (willDelete) {
                    axios.delete(urlToRedirect, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            swal("Deleted!", "The record has been deleted.", "success")
                            .then(() => {
                                // Optionally, reload the page or redirect

                                setTimeout(function() {
                                    window.location.href = '/company-info/list';
                                }, 2000);

                                //laravel toaster message display
                                Command: toastr["success"]("Delete", "Delete Sussessfull")
                                toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                                }

                            });
                        } else {
                            swal("Error!", "There was an error deleting the record.", "error");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        swal("Error!", "There was an error deleting the record.", "error");
                    });
                }
            });
        }

        $(document).ready(function(){
        // Initialize Bootstrap tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Toggle additional text when icon is clicked
        $('#add-company-info-svg').click(function(){
            $('#additionalText').toggle();
        });
    });
    </script>

@endsection











///////////////////////////////////////////////////////////////////////////////

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
        $listCompanyInfo = CompanyInfo::all(); 
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



    // public function updateCompanyInfo(Request $request, $id)
    // {
    //     try {
    //         $companyInfo = CompanyInfo::findOrFail($id);
    //         $companyInfo->update([
    //             'name' => $request->input('update_name'),
    //             'address' => $request->input('update_address'),
    //             'email' => $request->input('update_email'),
    //             'phone' => $request->input('update_phone'),
    //             'website' => $request->input('update_website'),
    //             'description' => $request->input('update_description')
    //         ]);
    //         return response()->json(['success' => true]);

    //     } catch (Exception $exception) {
    //         Log::error($exception);
    //         return response()->json(['success' => false, 'error' => $exception->getMessage()], 500);
    //     }
    // }


    // public function updateCompanyInfo(Request $request, $id)
    // {
    //     // Company model to update the company information
    //     $company = CompanyInfo::findOrFail($id);
    //     $company->name = $request->name;
    //     $company->address = $request->address;
    //     $company->email = $request->email;
    //     $company->phone = $request->phone;
    //     $company->website = $request->website;
    //     $company->description = $request->description;
    //     $company->save();

    //     return response()->json(['status' => 'success', 'message' => 'Company information updated successfully.']);
    // }


    public function updateCompanyInfo(Request $request, $id)
    {
        try {
            // Company model to update the company information
            $company = CompanyInfo::findOrFail($id);
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
                return redirect()->back()->withInput()->withErrors(['error' => 'input field is required. please try again.']);
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





//////////////////////////


@extends('frontend.layout.app')
@section('content')

    <div class="row">

        <!-- left column -->
        <div class="col-md-12">

            <div class="card card-gray mr-3 ml-3 shadow">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="text-primary m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">
                    Company Edit
                    </h5>
                    <a href="{{ url('/company-info/list') }}" class="ml-auto" id="iconLink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0056b3" class="bi bi-skip-backward-circle" viewBox="0 0 16 16"  data-toggle="tooltip" data-placement="left" title="Back List">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M11.729 5.055a.5.5 0 0 0-.52.038L8.5 7.028V5.5a.5.5 0 0 0-.79-.407L5 7.028V5.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0V8.972l2.71 1.935a.5.5 0 0 0 .79-.407V8.972l2.71 1.935A.5.5 0 0 0 12 10.5v-5a.5.5 0 0 0-.271-.445"/>
                        </svg>
                    </a>
                </div>

                
                <!-- form start -->
                <form id="company-info-form">
                    <div class="card-body ">

                        <div class="form-group">
                            <label for="name">Name</label><br>
                            <input type="text" class="form-control" id="update_name" name="name" placeholder="name" value="{{ $editCompanyInfo->name }}"><br>

                            <span class="text-danger p-0 mb-4 d-none" id="update-name-error"> * Name is required</span>
                        </div>

                        <div class="row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="address">Address</label><br>
                                    <input type="text" class="form-control" id="update_address" name="address" placeholder="address" value="{{ $editCompanyInfo->address }}"><br>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger p-0 mb-4 d-none" id="email-error"></span> </label><br>
                                    <input type="email" class="form-control" id="update_email" name="email" placeholder="email" value="{{ $editCompanyInfo->email }}"><br>
                                    
                                    <span class="text-danger p-0 mb-4 d-none" id="update-email-error"> * Email is required</span>
                                    <span class="text-danger p-0 mb-4 d-none" id="update-email-format-error"> * Invalid your email format</span>
                                    <span class="text-danger p-0 mb-4 d-none" id="update-email-format-unique"> * Email already exits </span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label><br>
                                    <input type="text" class="form-control" id="update_phone" name="phone" placeholder="phone" value="{{ $editCompanyInfo->phone }}"><br>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="website">Website</label><br>
                                    <input type="text" class="form-control" id="update_website" name="website" placeholder="website" value="{{ $editCompanyInfo->website }}"><br>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="textarea" name="description" placeholder="description" class="form-control" id="update_description">{{ $editCompanyInfo->description }}</textarea><br>
                        </div>

                        <!-- Submit button -->
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primary btn-block col-sm-1 mx-auto" id="edit-submit-btn">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection



@section('script')
    <script>
        $(document).ready(function(){
            $('#edit-submit-btn').on('click', async function(e){
                e.preventDefault();

                let name = $('#update_name').val();
                let address = $('#update_address').val();
                let email = $('#update_email').val();
                let phone = $('#update_phone').val();
                let website = $('#update_website').val();
                let description = $('#update_description').val();
                //console.log(name, address, email, phone, website, description);

                // Validation
                //console.log(name.length)
                if(name.length === 0){
                    $('#update-name-error').removeClass('d-none');
                    $('#update_name').focus();
                    // alert('Name is requered');
                    // showErrorToastr("Name is required");
                    return;
                }else{
                    $('#update-name-error').addClass('d-none');
                }

                if(email.length === 0){
                    $('#update-email-error').removeClass('d-none');
                    $('#update_email').focus();
                    // alert('Email is requered');
                    // showErrorToastr("Email is required");
                    return;
                }else{
                    $('#update-email-error').addClass('d-none');
                }

                // Email format validation
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $('#update-email-format-error').removeClass('d-none');
                    $('#email').focus();
                    return;
                } else {
                    $('#update-email-format-error').addClass('d-none');
                }

                let companyFormData = {
                    name: name,
                    address: address,
                    email: email,
                    phone: phone,
                    website: website,
                    description: description
                };

                // Check if the email has changed
                // if (email !== existingEmail) {
                //     let emailExists = await axios.post("/company-info/check-email", { email: email });
                //     if (emailExists.data.status === 'failed') {
                //         $('#update-email-format-unique').removeClass('d-none');
                //         return;
                //     } else {
                //         $('#update-email-format-unique').addClass('d-none');
                //     }
                // }

                let URL = "/company-info/update/{{ $editCompanyInfo->id }}";

                    let result = await axios.post(URL, companyFormData);
                     // console.log(result);

                    if(result.data.status === 'failed' && result.data.email != '' ){
                        $('#update-email-format-unique').removeClass('d-none');
                        return;
                        }
                        // else if(''){
                       
                        // }
                        else if(result.data.status === 'success'){
                        setTimeout(function() {
                            window.location.href = '/company-info/list';
                        }, 2000);
                    
                    }else{
                        alert('Something went wrong ok');
                    }

                    

            });
        });
    </script>
@endsection
