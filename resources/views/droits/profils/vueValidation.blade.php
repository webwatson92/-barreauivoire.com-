@extends('layouts.base2')
@section('title', 'Interface de validation de profil')
@section('content')
    @section('titlePage')  <h1 class="m-0">Validation du profil</h1> @stop
    <div class="container">
        <!-- include('layouts.flash-message') -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div id="message-validation-profil" class="alert hidden"></div>
                    <div class="col-md-12 col-sm-12">
                       <div class="card">
                            <div class="card-body">
                                <div class="row container">
                                    <form id="validation-profil-form" action="{{ route('admin.valider.validation', $userInformation->id) }}" method="post">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success" role="alert"><strong>{{Session::get('message')}}</strong></div>
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" id="decision" name="decision">
                                        <input type="hidden" id="idProfil" name="idProfil" value="{{ $userInformation->id }}">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div style="width:50%;background-color:#3B71CA; height:30px; padding:5px; color:#FBFBFB; font-weight: bold; font-size: 100%;">
                                                    INFORMATION PERSONNELLE
                                                </div>
                                                <div style="width:100%;background-color:#3B71CA; height:3px;margin-bottom:5px;"></div>
                                                <!-- <span style="border: 2px solid blue;width: 100em; height: 20px"></span> -->
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="prenom" class="control-label">Prénom (*)</label>
                                                        <input type="text" value="{{ $userInformation->prenom ? $userInformation->prenom : '' }}"  placeholder="Prénom" name="prenom" class="form-control">
                                                        @error('prenom') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="dateMask" class="control-label">Date Naissance (*)</label>
                                                        <input type="date" value="{{ $userInformation->date_naissance ? $userInformation->date_naissance : '' }}" name="date_naissance" placeholder="JJ/MM/YYYY" id="dateMask" class="form-control">
                                                        @error('date_naissance') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div style="width:50%;background-color:#3B71CA; height:30px; padding:5px; color:#FBFBFB; font-weight: bold; font-size: 100%;">
                                                    AUTRES INFORMATIONS
                                                </div>
                                                <div style="width:100%;background-color:#3B71CA; height:3px;margin-bottom:5px;"></div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="lieu_structure" class="control-label">Lieu de fonction (*)</label>
                                                        <input type="text" value="{{ $userInformation->lieu_structure ? $userInformation->lieu_structure : '' }}" name="lieu_structure" placeholder="Abidjan" id="lieu_structure" class="form-control">
                                                        @error('lieu_structure') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    
                                                    <div class="col-sm-6 form-group">
                                                        <label for="expertise" class="control-label">Expertise</label>
                                                        <input type="text" value="{{ $userInformation->expertise ? $userInformation->expertise : '' }}" name="expertise" placeholder="Droit des affaires" id="expertise" class="form-control">
                                                        @error('expertise') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="" style="float:right">
                                            <a href="{{ route('admin.liste.validation') }}" class="btn btn-danger pull-right"id="quitter"><i class="fa fa-reply"></i> RETOUR</a>
                                            <button class="btn btn-warning"id="rejeter"><i class="fa-solid fa-ban"></i> REFUSER</button>
                                            <button class="btn btn-success" type="submit" id="valider-profil"><i class="fa-solid fa-circle-check"></i> ACCEPTER</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('footer') 
    <script>
        $(document).ready(function(){
            var $form = '';
            var $urlExecution = $('#validation-profil-form').attr('action');

            $('#rejeter').on('click', function(e){
                e.preventDefault();
                $('#decision').val(4);
                $form = '#validation-profil-form';
                $('#message-validation-profil').addClass('hidden').html('');
               
                $urlExecution = $('#validation-profil-form').attr('action');
                $($form).trigger('submit');
            });

            $("#quitter").on("click", function(){
                document.location = "{{route('admin.liste.validation')}}";
            });

            $('#valider-profil').on('click', function(e){
                e.preventDefault();
                $form = '#validation-profil-form';
                $('#decision').val(2);
                $('#message-validation-profil').addClass('hidden').html('');
                $urlExecution = $('#validation-profil-form').attr('action');
                $($form).trigger('submit');
            });

            $('#validation-profil-form').on('submit', function(e){
                $.ajaxSetup({
                    header:$('meta[name="_token"]').attr('content')
                });
                e.preventDefault();
                $.ajax({
                    url : $urlExecution,
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType : 'json',
                    success : function(data){
                        $('#message-validation-profil').removeClass('hidden').addClass(data.class).html(data.message);
                        if(data.class === 'alert-success'){
                            setTimeout(function(){
                                window.location.href = data.redirection;
                            }, 5000);
                        }
                    },
                    error: function(xhr, status, error){
                        var err = eval("(" + xhr.responseText + ")");
                        var message = err.message;
                        $('#message-validation-profil').removeClass('hidden').addClass('alert-danger').html(message);
                    }
                });
            });
            
        })
    </script>
@stop 
