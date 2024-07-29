  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    @livewire('layout.navigation')

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar" style="background-color:#272d69; color: #fff" elevation-4">
    <!-- Brand Logo -->
    <a href="{{ Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'  ? route('admin') : route('admin.home') }}" class="brand-link">
      <img src="" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MON BARREAU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name .' '.Auth::user()->prenom}}</a> 
          <!-- <p style="margin-top:1em">Compte Type : <span style="background-color: red;color: #fff;padding: .5em">{{ Auth::user()->role }}</span></p> -->
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
            <!-- @admin
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa-solid fa-sliders"></i>
                  <p>
                    Paramètre
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.droit.accueil') }}" class="nav-link">
                      <i class="fa-solid fa-user"></i>
                      <p>Gestion de compte</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ Auth::user()->role =='admin' || 
                              Auth::user()->role =='superadmin' || Auth::user()->role =='barreau'
                                ? route('vue.listedeprofil') 
                                : route('vue.profil.utilisateur')}}" 
                                class="nav-link">
                        <i class="fa-solid fa-compass"></i>
                        Gestion de Profil
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.vue.edition.droit.utilisateur', Auth::user()->id) }}" class="nav-link">
                        <i class="fa-solid fa-user"></i>
                        Mon Profil
                    </a>
                  </li>  
                </ul>
              </li>
            @endadmin -->
            @adminbarreau
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa-solid fa-sliders"></i>
                  <p>
                    Paramètre
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right"></span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.droit.accueil') }}" class="nav-link">
                      <i class="fa-solid fa-user"></i>
                      <p>Gestion de compte</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ Auth::user()->role =='admin' || 
                              Auth::user()->role =='superadmin' || Auth::user()->role =='barreau'
                                ? route('vue.listedeprofil') 
                                : route('vue.profil.utilisateur')}}" 
                                class="nav-link">
                        <i class="fa-solid fa-compass"></i>
                        Gestion de Profil
                    </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{  route('vue.listedecode') }}" class="nav-link">
                          <i class="fa-solid fa-landmark"></i>
                          Code d'inscription
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.vue.edition.droit.utilisateur', Auth::user()->id) }}" class="nav-link">
                        <i class="fa-solid fa-user"></i>
                        Mon Profil
                    </a>
                  </li>  
                </ul>
              </li>
            @endadminbarreau
            @if(Auth::user()->role == "user" || "Auth::user()->role == "avocat")
              <li class="nav-item">
                <a href="{{ route('vue.compte.utilisateur', Auth::user()->id) }}" class="nav-link">
                    <i class="fa-solid fa-user"></i>
                    Mon Profil
                </a>
              </li>
            @endif
            
            <li class="nav-item">
              <a href="{{ route('vue.liste.contact') }}" class="nav-link">
                  <i class="fa-solid fa-phone-volume"></i>
                  Contact
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('evenements.index') }}" class="nav-link">
                  <i class="fa-solid fa-calendar-days"></i>
                  Evènement
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                  <i class="fa-solid fa-magnet"></i>
                  Saisines
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fa-solid fa-folder-open"></i>
                  Document
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                  <i class="fa-solid fa-compass"></i>
                  Formation
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('vue.liste.annuaire') }}" class="nav-link">
              <i class="fa-solid fa-address-card"></i>
                  Annuaire
              </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>