
@extends('frontend.layout.app')
@section('content')

    <div class="row">

        <!-- left column -->
        <div class="col-md-12">

            <div class="card card-gray mr-3 ml-3 shadow">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="text-primary m-0 font-weight-bold text-primary d-flex justify-content-between align-items-center">
                    Contact Company
                    </h5>
                    <a href="{{ url('/company-contact/list') }}" class="ml-auto" id="iconLink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0056b3" class="bi bi-skip-backward-circle" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Back List">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M11.729 5.055a.5.5 0 0 0-.52.038L8.5 7.028V5.5a.5.5 0 0 0-.79-.407L5 7.028V5.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0V8.972l2.71 1.935a.5.5 0 0 0 .79-.407V8.972l2.71 1.935A.5.5 0 0 0 12 10.5v-5a.5.5 0 0 0-.271-.445"/>
                        </svg>
                    </a>
                </div>

                
                <!-- form start -->
                <form id="company-info-form">
                    <div class="card-body ">

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="company_info_fk">Company</label>
                                    <select name="company_info_fk" id="company_info_fk" class="form-control select2" style="width: 100%;">
                                    @foreach ($companyInfo as $companyInf)
                                        <option value="{{$companyInf->id}}"> {{$companyInf->name}} </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="name">Name</label><br>
                            <input type="text" class="form-control" id="name" name="name" placeholder="name" value="{{ old('name') }}"><br>

                            <span class="text-danger p-0 mb-4 d-none" id="name-error"> * Name is required</span>
                        </div>

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label><br>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="contact number"><br>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label><br>
                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="email"><br>

                                    <span class="text-danger p-0 mb-4 d-none" id="email-id-error"> * Email is required</span>
                                    <span class="text-danger p-0 mb-4 d-none" id="email-id-format-error"> * Invalid your email format</span>
                                    <span class="text-danger p-0 mb-4 d-none" id="email-id-format-unique"> * Email already exits </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="textarea" name="description" placeholder="description" class="form-control" id="description"></textarea>
                        </div><br>

                        <!-- Submit button -->
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primary btn-block col-sm-1 mx-auto" id="submit-btn">Submit</button>
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
        $().ready(function(){
            // console.log('hghgh')
            $('#submit-btn').on('click', async function(e){
                e.preventDefault();

                let name = $('#name').val();
                let address = $('#email_id').val();
                let email = $('#description').val();
                let phone = $('#contact_number').val();
                //console.log(name, email_id, description, contact_number);

                //validation
                //console.log(name.length)
                if(name.length===0){
                    $('#name-error').removeClass('d-none');
                    $('#name').focus();
                    // alert('Name is requered');
                    // showErrorToastr("Name is required");
                    return
                }else{
                    $('#name-error').addClass('d-none');
                }
                if(email.length === 0){
                    $('#email-error').removeClass('d-none');
                    $('#email').focus();
                    // alert('Email is requered');
                    // showErrorToastr("Email is required");
                    return
                }
                else{
                    $('#email-error').addClass('d-none');
                }

                // Email format validation
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $('#email-format-error').removeClass('d-none');
                    $('#email').focus();
                    return;
                } else {
                    $('#email-format-error').addClass('d-none');
                }

                let companyFormData = {
                    name:name,
                    address:address,
                    email:email,
                    phone:phone,
                    website:website,
                    description:description
                }

                let URL = "/company-contact/create";
                
                let result = await axios.post(URL,companyFormData)
                // console.log(result);

                if(result.data.status === 'failed' && result.data.email != ''){
                    $('#email-format-unique').removeClass('d-none');
                    return;
                }else if(result.data.status === 'success'){
                    setTimeout(function() {
                        window.location.href = '/company-contact/list';
                    }, 2000);
                    
                }else{
                    alert('Something went wrong!');
                }
                
            })
        });


    </script>

@endsection





