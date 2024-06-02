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
                                    <label for="email">Email</label><br>
                                    <input type="email" class="form-control" id="update_email" name="email" placeholder="email" value="{{ $editCompanyInfo->email }}"><br>
                                    
                                    <span class="text-danger p-0 mb-4 d-none" id="update-email-error"> * Email is required</span>
                                    <span class="text-danger p-0 mb-4 d-none" id="update-email-format-error"> * Invalid email format</span>
                                    <span class="text-danger p-0 mb-4 d-none" id="update-email-format-unique"> * Email already exists </span>
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

                // Validation
                if(name.length === 0){
                    $('#update-name-error').removeClass('d-none');
                    $('#update_name').focus();
                    return;
                } else {
                    $('#update-name-error').addClass('d-none');
                }

                if(email.length === 0){
                    $('#update-email-error').removeClass('d-none');
                    $('#update_email').focus();
                    return;
                } else {
                    $('#update-email-error').addClass('d-none');
                }

                // Email format validation
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $('#update-email-format-error').removeClass('d-none');
                    $('#update_email').focus();
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

                let URL = "/company-info/update/{{ $editCompanyInfo->id }}";

                try {
                    let result = await axios.post(URL, companyFormData);

                    if (result.data.status === 'failed' && result.data.email) {
                        $('#update-email-format-unique').removeClass('d-none');
                        return;
                    } else {
                        $('#update-email-format-unique').addClass('d-none');
                    }

                    if (result.data.status === 'success') {
                        setTimeout(function () {
                            window.location.href = '/company-info/list';
                        }, 2000);
                    } else {
                        alert('Something went wrong.');
                    }

                } catch (error) {
                    console.error('An error occurred:', error);
                    alert('An error occurred while updating the company information.');
                }
            });

        });

    </script>
    
@endsection
