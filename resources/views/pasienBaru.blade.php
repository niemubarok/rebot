@extends('layouts.form')

@section('formpasienbaru')



<div class="inputGroupContainer mb-4">
        <div class="input-group" style="margin-top: -10px">
            <div class="input-group-prepend">
                <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                    <i class="fas fa-id-card fa-2x"></i>
                </div>
                
                <input id="no_ktp" name="no_ktp" placeholder="Nomor KTP" value="{{old('no_ktp')}}" class="@error('no_ktp') is-invalid @enderror form-control-lg border-top-0 border-right-0" type="text" style="margin-left: -10px">
                @error('no_ktp')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                    
            </div>
        </div>
 </div>

 <div class="inputGroupContainer mb-4">
        <div class="input-group" style="margin-top: -10px">
            <div class="input-group-prepend " >
                <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                    <i class="fas fa-id-badge fa-2x ml-auto mr-auto"></i>
                </div>
                
                <input id="fullname" name="fullname" placeholder="Nama Lengkap" value="{{old('fullname')}}" class="form-control-lg border-top-0 border-right-0 " type="text" style="margin-left: -10px">
                    
            </div>
        </div>
 </div>

 <div class="inputGroupContainer mb-4">
    <div class="input-group" style="margin-top: -10px">
        <div class="input-group-prepend " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-map-marker-alt fa-2x ml-auto mr-auto"></i>
            </div>
            
            <input id="birthplace" name="birthplace" placeholder="Tempat Lahir" value="{{old('birthplace')}}" class="form-control-lg border-top-0 border-right-0" type="text" style="margin-left: -10px">
                
        </div>
    </div>
</div>

<div class="inputGroupContainer mb-4">
    <div class="input-group" style="margin-top: -10px">
        <div class="input-group-prepend " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-calendar-alt fa-2x ml-auto mr-auto"></i>
            </div>
            
            <input id="birthdate" name="birthdate" placeholder="Tanggal Lahir" value="{{old('birthdate')}}" class="date form-control-lg border-top-0 border-right-0" data-date-format="mm/dd/yyyy" type="text" style="margin-left: -10px">
                
        </div>
    </div>
</div>

<div class="inputGroupContainer mb-4 ">
    <div class="input-group" style="margin-top: -10px">
        <div class="input-group-prepend mr-1 " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-venus-mars fa-2x"></i>
            </div>
            
            <select id="gender" name="gender" class="form-control-md border-top-0 border-right-0 pl-1" type="text" style="margin-left: -10px">
                
                <option>Jenis Kelamin</option>
                <option>L</option>
                <option>P</option>
            </select>
                
        </div>
        <div class="input-group-prepend " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-tint fa-2x ml-auto mr-auto"></i>
            </div>
            
            <select id="blood" name="blood" class="form-control-md border-top-0 border-right-0 pl-2" type="text" style="margin-left: -10px">
                <option selected>Golongan Darah</option>
                <option value="o">O</option>
                <option>A</option>
                <option>B</option>
                <option>AB</option>
            </select>
                
        </div>
    </div>
</div>

<div class="inputGroupContainer mb-4">
    <div class="input-group" style="margin-top: -10px">
        <div class="input-group-prepend " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-map-marked-alt fa-2x"></i>
            </div>
            
        <input id="address" name="address" placeholder="Alamat Lengkap" value="{{old('address')}}" class="form-control-lg border-top-0 border-right-0" type="text" style="margin-left: -10px">
                
        </div>
    </div>
</div>

<div class="inputGroupContainer mb-4 ">
    <div class="input-group" style="margin-top: -10px">
        <div class="input-group-prepend " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-female fa-2x ml-auto mr-auto"></i>
            </div>
            
            <input id="mother" name="mother" placeholder="Nama Ibu Kandung" value="{{old('mother')}}" class="form-control-lg border-top-0 border-right-0" type="text" style="margin-left: -10px">
                
        </div>
    </div>
</div>

<div class="inputGroupContainer mb-4">
    <div class="input-group" style="margin-top: -10px">
        <div class="input-group-prepend " >
            <div class="input-group-text" style="color: #22262E; background-color:lightsalmon; width:60px; z-index:100">
                <i class="fas fa-mobile-alt fa-2x ml-auto mr-auto"></i>
            </div>
            
            <input id="phone" name="phone" placeholder="Nomor HP" value="{{old('phone')}}" class="form-control-lg border-top-0 border-right-0" type="text" style="margin-left: -10px">
                
        </div>
    </div>
</div>

<div class="inputGroupContainer mb-4">
    <div class="input-group" style="margin-top: -10px">

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
            Saya sudah membaca dan menyetujui <br><a href="">general consent</a>.
            </label>
        </div>
    </div>
</div>

<input type="submit" value="SIMPAN" class="btn btn-primary">







 
@endSection
    
    