@extends('layouts.master')
@section('content')

<div class="container-fluid bg bg-secondary">
    <div class="row justify-content-center bg-white">

     

        <div class="col-auto d-flex ">
        <img src="http://www.rsalisibrohmalisi.com/wp-content/uploads/2019/12/sibroh-logo-baru.jpg" class="rounded">
        </div>
    </div>
    <div class="row justify-content-center" >
        

        <div class="col-auto d-flex">
            <div class="card  mb-2 p-1 " style="background-color: lightsalmon; margin-top: -10px">
                
                <h1 class="font-weight-bold">FORM PASIEN BARU</h1>
                <div class="card-body" style="margin-top: -30px; padding-bottom: -20px">
                        Silahkan Lengkapi Formulir di bawah ini:
                </div>
            </div>
          </div>
    </div>

    <div class="row justify-content-center " style="margin-top:10px">
        <div class="col col-auto d-flex ">
        
            <form class="well form-horizontal" action="/proses " method="post"  id="contact_form">
                <!-- Form Name -->
                <div class="form-group">
                    @csrf
                    @yield('formpasienbaru')
                </div>    
            </form>   
            
        </div>
    </div>
</div>

@endsection
