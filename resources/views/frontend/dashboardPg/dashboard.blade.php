
@extends('frontend.layout.app')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="antialiased">

            <form action="{{ url('/') }}" method="post" enctype="multipart/ form-data">
                @csrf

                <div class="form-group">
                    <h1>Hello Coder71</h1>
                </div>

            </form>
        </div> 
    </div>
            
@endsection

