@extends('frontend.layout.app')
@section('content')

    <div class="card mb-4 shadow pb-3 mr-3 ml-3">

        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 font-weight-bold text-primary">
                        Company List
                    </h5>
                </div>
                <div class="col-auto">
                    <a href="{{ url('/company-info') }}" class="mb-4 inline-block" id="iconLink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0056b3" class="bi bi-plus-square" viewBox="0 0 16 16" data-toggle="tooltip" data-placement="left" title="Add" >
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                    </a>
                </div>
            </div>
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

        
    </script>

@endsection