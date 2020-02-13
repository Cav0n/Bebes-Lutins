@extends('templates.customer-area')

@section('body')
<div class="row m-0">
    <div class="col-12 p-0">
      <div class="row m-0">
        <div class="col-12 p-0">
          <a href='/espace-client/adresses' class="small text-muted">< Mes adresses</a>
          <p class='h5 font-weight-bold'>Nouvelle adresse</p>          
        </div>
      </div>
      <div class="row m-0">
        <div class="col-12 p-0">

          {{-- Errors --}}
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul class='mb-0'>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
              </ul>
          </div>
          @endif

          <form action="/espace-client/adresses/creation" method="POST">
            @csrf
            <div class="row">
              <div class="col-2">

                <div class="form-group">
                  <label for="civility">Civilité</label>
                  <select class="form-control @error('civility') is-invalid @enderror" name="civility" id="civility" style="font-size:0.8rem;">
                    <option value="1" selected>Monsieur</option>
                    <option value="2">Madame</option>
                    <option value="3">Autre</option>
                  </select>
                  @error('civility')
                    <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>

              </div>
              <div class="col-5">

                <div class="form-group">
                  <label for="lastname">Nom du destinataire</label>
                  <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" id="lastname" aria-describedby="helpLastname" placeholder="" value='{{old('lastname')}}'>
                  <small id="helpLastname" class="form-text text-muted">Nom</small>
                  @error('lastname')
                    <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>

              </div>
              <div class="col-5">

                <div class="form-group">
                  <label for="firstname">Prénom du destinataire</label>
                  <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" id="firstname" aria-describedby="helpFirstnam" placeholder="" value='{{old('firstname')}}'>
                  <small id="helpFirstname" class="form-text text-muted">Prénom</small>
                  @error('firstname')
                    <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>

              </div>
            </div>

            <div class="form-group">
              <label for="street">Rue</label>
              <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" id="street" aria-describedby="helpStreet" placeholder="" value='{{old('street')}}'>
              <small id="helpStreet" class="form-text text-muted">Le nom de votre rue</small>
              @error('street')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="zipcode">Code postal</label>
              <input type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" id="zipcode" aria-describedby="helpZipcode" placeholder="" value='{{old('zipcode')}}'>
              <small id="helpZipcode" class="form-text text-muted">Votre code postal</small>
              @error('zipcode')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="city">Ville</label>
              <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" aria-describedby="helpCity" placeholder="" value='{{old('city')}}'>
              <small id="helpCity" class="form-text text-muted">Le nom de la ville</small>
              @error('city')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="complement">Complement</label>
              <input type="text" class="form-control @error('complement') is-invalid @enderror" name="complement" id="complement" aria-describedby="helpComplement" placeholder="" value='{{old('complement')}}'>
              @error('complement')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="company">Entreprise</label>
              <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" id="company" aria-describedby="helpCompany" placeholder="" value='{{old('company')}}'>
              <small id="helpCompany" class="form-text text-muted">Nom de l'entreprise</small>
              @error('company')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection