<div class="card-body" style="padding-bottom: 2em; padding-top: 1em">
    <div class="row container">
        <form action="{{ route('admin.creer.utilisateur') }}" method="post">
            @if(Session::has('message'))
                <div class="alert alert-success" role="alert"><strong>{{Session::get('message')}}</strong></div>
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="row">
                <div class="col-sm-6">
                    <div style="width:50%;background-color:#3B71CA; height:30px; padding:5px; color:#FBFBFB; font-weight: bold; font-size: 100%;">
                        INFORMATION PERSONNELLE
                    </div>
                    <div style="width:100%;background-color:#3B71CA; height:3px;margin-bottom:5px;"></div>
                    <!-- <span style="border: 2px solid blue;width: 100em; height: 20px"></span> -->
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="code" class="control-label">Code (*)</label>
                            <input type="text"  placeholder="Code barreau" name="code" class="form-control">
                            @error('code') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="matricule" class="control-label">Matricule (*)</label>
                            <input type="text"  placeholder="0GD02024" name="matricule" class="form-control">
                            @error('matricule') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="name" class="control-label">Nom (*)</label>
                            <input type="text"  placeholder="Nom" name="name" class="form-control">
                            @error('name') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="prenom" class="control-label">Prénom (*)</label>
                            <input type="text"  placeholder="Prénom" name="prenom" class="form-control">
                            @error('prenom') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="email" class="control-label">Email (*)</label>
                            <input type="email"  placeholder="Email" name="email" class="form-control">
                            @error('email') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="dateMask" class="control-label">Date Naissance (*)</label>
                            <input type="date" name="date_naissance" placeholder="JJ/MM/YYYY" id="dateMask" class="form-control">
                            @error('date_naissance') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="sexe" class="control-label">Sexe (*)</label>
                            <select name="sexe" id="sexe" class="form-control">
                                <option>Choisissez votre sexe</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                            @error('sexe') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="telephone" class="control-label">Téléphone (*)</label>
                            <input type="text" name="telephone" placeholder="(+225) xxxxxxxx" id="telephone" class="form-control">
                            @error('telephone') <p class="text-danger">{{$message}}</p>@enderror
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
                            <input type="text" name="lieu_structure" placeholder="Abidjan" id="lieu_structure" class="form-control">
                            @error('lieu_structure') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="role" class="control-label">Type de Compte (*)</label>
                            <select name="role" class="form-control" id="role">
                                <option>Choisissez un profil</option>
                                <option value="admin">Administrateur</option>
                                <option value="barreau">Barreau</option>
                                <option value="avocat">Avocat</option>
                                <option value="user">Auditeur Avocat</option>
                            </select>
                            @error('role') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="dateMask" class="control-label">Date de prestation</label>
                            <input type="date" name="date_prestation" placeholder="JJ/MM/YYYY" id="dateMask" class="form-control">
                            @error('date_prestation') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="expertise" class="control-label">Expertise</label>
                            <input type="text" name="expertise" placeholder="Droit des affaires" id="expertise" class="form-control">
                            @error('expertise') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="dateMask" class="control-label">Numéro Toge</label>
                            <input type="text" name="num_toge" placeholder="N°" class="form-control">
                            @error('num_toge') <p class="text-danger">{{$message}}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="" style="float:right">
                <a class="btn btn-danger" href='@if(Auth::user()->role == "superadmin" || Auth::user()->role == "admin")  {{ route("admin") }}
                @elseif(Auth::user()->role == "avocat")  {{ route("avocat") }}
                @elseif(Auth::user()->role == "barreau") {{ route("barreau") }}
                @else  {{ route("admin.home") }}
                @endif'><i class="fa fa-reply"></i> RETOUR</a>
                <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-save"></i> SOUMETTRE</button>
            </div>
        </form>
    </div>
</div>

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
        $(document).ready(function(){

            $("#dateMask").inputmask("dd/mm/yyyy", {"placeholder": "dd-mm-yyyy"});

            var dateFinInput = $('#dateMask');

            dateFinInput.on('input', function() {
                var currentDate = new Date(); // Obtenir la date actuelle

                // Limite supérieure fixée à la date actuelle
                var maxYear = currentDate.getFullYear();
                var maxMonth = currentDate.getMonth() + 1; // Les mois sont indexés à partir de 0, donc on ajoute 1
                var maxDay = currentDate.getDate();

                // Formater la date actuelle dans le format 'YYYY-MM-DD'
                var maxDate = maxYear + '-' + (maxMonth < 10 ? '0' + maxMonth : maxMonth) + '-' + (maxDay < 10 ? '0' + maxDay : maxDay);

                var selectedDate = $(this).val();
                
                // Vérifier si la date sélectionnée est postérieure à la date actuelle
                if (selectedDate > maxDate) {
                    alert('La date ne peut pas être postérieure à aujourd\'hui.');
                    $(this).val(''); // Réinitialiser la valeur du champ
                }
            });
        });
    </script>
@stop