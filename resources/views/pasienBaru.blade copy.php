<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/3219f97a2c.js" crossorigin="anonymous"></script>

    <style>#success_message{ display: none;}</style>
    <title>Registrasi Pasien Baru</title>
</head>
<body>
   

    <div class="container justify-content-center" style="border: black 1px" >
        <div class="row justify-content-center">
            <div class="col ">

                
                <form class="well form-horizontal" action=" " method="post"  id="contact_form">
                        <fieldset>
                        <!-- Form Name -->
                        <legend>FORM PASIEN BARU</legend>
                        
                        <!-- Text input-->
                        
                        {{-- <div class="form-group">
                            <div class="col-md-4 inputGroupContainer">
                                <span style="color: lightsalmon">
                                    <i class="fas fa-id-card fa-2x">
                                        <label style="font-size: 20px">NO  . KTP*</label>  
                                    </i>
                                </span>
                                <div class="input-group">
                                    <input  name="no_ktp" class="form-control border-success"  type="text">
                                </div>
                            </div>
                        </div> --}}

                         <!-- Text input-->
                        
                         <div class="form-group">
                            <div class="col-md-4 inputGroupContainer">
                                {{-- <label class="h9" style="color: lightsalmon" >NO.KTP*</label>  --}}
                                <div class="input-group" style="margin-top: -10px">
                                <span class= "pl-1 pt-1" style="color: lightsalmon; background-color:#BBE2C6">
                                    <i class="fas fa-id-card fa-2x pr-1"></i>
                                </span>
                                    <input name="no_ktp" placeholder="NOMOR KTP" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Text input-->
                        
                        <div class="form-group">
                            <div class="col-md-4 inputGroupContainer">
                                <span style="color: lightsalmon">
                                    <i class="fas fa-id-badge fa-2x"></i>
                                    <label class="h7" >NAMA LENGKAP</label> 
                                </span>
                                <div class="input-group">
                                    <input name="full_name" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="form-group">
                            <div class="col-md-4 inputGroupContainer">
                                <span style="color: lightsalmon">
                                    <i class="fas fa-map-marker-alt fa-2x"></i>
                                    <label class="h7">TEMPAT LAHIR</label>  
                                </span>
                                <div class="input-group">
                                    <input name="birthplace"class="form-control"  type="text">
                                </div>
                            </div>
                        </div>

                          <!-- Text input-->
                          <div class="form-group">
                            <div class="col-md-4 inputGroupContainer">
                                <span style="color: lightsalmon">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                    <label class="h7">TANGGAL LAHIR</label>  
                                </span>
                                <div class="input-group">
                                    <input name="birthdate"class="form-control"  type="text">
                                </div>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <div class="col-md-4 inputGroupContainer">
                                <span style="color: lightsalmon">
                                    <i class="fas fa-calendar-alt fa-2x"></i>
                                    <label class="h7">JENIS KELAMIN</label>  
                                </span>
                                <div class="input-group">
                                    <input name="birthdate"class="form-control"  type="text">
                                </div>
                            </div>
                        </div>

                        
                   