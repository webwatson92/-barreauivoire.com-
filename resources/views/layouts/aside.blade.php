<aside id="sidebar" class="sidebar">
    
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'barreau'  ? route('admin') : route('admin.home') }}">
          <i class="bi bi-grid"></i>
          <span>Accueil</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @admin
        <!-- <li class="nav-item">
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
                <a href="{{  route('vue.listedecode') }}" class="nav-link">
                    <i class="fa-solid fa-landmark"></i>
                    Code d'inscription
                </a>
            </li>
          </ul>
        </li> -->
        <!-- <li class="nav-item">
              <a href="{{ Auth::user()->role =='admin' || 
                        Auth::user()->role =='superadmin' || Auth::user()->role =='barreau'
                          ? route('vue.listedeprofil') 
                          : route('vue.profil.utilisateur')}}" 
                          class="nav-link">
                  <i class="fa-solid fa-compass"></i>
                  Gestion de Profil
              </a>
        </li> -->
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <i class="fas fa-angle-left right"></i>
              Paramètre
          </a>
          <div class="dropdown-menu">
              <a href="{{ route('admin.droit.accueil') }}" class="nav-link">
                <i class="fa-solid fa-user"></i>
                <p>Gestion de compte</p>
              </a>
              <a href="{{  route('vue.listedecode') }}" class="nav-link">
                    <i class="fa-solid fa-landmark"></i>
                    Code d'inscription
              </a>
              <a href="/liste/des/villes" class="nav-link">
                  <i class="fa-solid fa-phone-volume"></i>
                  Liste des villes
              </a>
              <a href="/liste/de/tribunal" class="nav-link">
                  <i class="fa-solid fa-phone-volume"></i>
                  Liste des tribunaux
              </a>
          </div>
      </li>
        <!-- <li class="nav-item">
          <a href="{{ route('admin.vue.edition.droit.utilisateur', Auth::user()->id) }}" class="nav-link">
              <i class="fa-solid fa-user"></i>
              Mon Profil
          </a>
        </li> -->
      @endadmin 
      @avocatuser
        <li class="nav-item">
          <a href="{{ route('vue.compte.utilisateur', Auth::user()->id) }}" class="nav-link">
              <i class="fa-solid fa-user"></i>
              Mon Profil
          </a>
        </li>
      @endavocatuser 
      <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa-solid fa-folder-open"></i>
            Courriers et conclusions 
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('vue.liste.document') }}" class="nav-link">
              <i class="fa-solid fa-folder-open"></i>
                Liste de vos courriers
            </a>
            <a href="{{ route('vue.liste.conclusion') }}" class="nav-link">
              <i class="fa-solid fa-folder-open"></i>
                Liste de vos conclusions
            </a>
          </div>
      </li>
      <li class="nav-item">
        <a href="{{route('vue.liste.contact')}}" class="nav-link">
            <i class="fa-solid fa-phone-volume"></i>
            Contacts
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('vue.compte-rendu') }}" class="nav-link">
            <i class="fa-solid fa-inbox"></i>
            Comptes rendus du Conseil de l’Ordre
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('information.create') }}" class="nav-link">
            <i class="fa-solid fa-layer-group"></i>
            Informations Barreau 
        </a>
      </li>
      <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa-solid fa-folder-open"></i>
            Evènements 
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('activite.index') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              Activités
            </a>
            <a href="{{ route('evenement.index') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              Evènements
            </a>
          </div>
      </li>
      <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa-solid fa-folder-open"></i>
            Agenda judiciaire 
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('vue.liste.audience') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              J'ajoute mon audience
            </a>
            <a href="{{ route('vue.recherche.audience') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              Je recherche une audience
            </a>
          </div>
      </li>
      <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa-solid fa-folder-open"></i>
            Modèles et Documents  
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('model-acte.index') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              Model d'acte
            </a>
            <a href="{{ route('type-document.index') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              Document type 
            </a>
          </div>
      </li>
      <li class="nav-item">
        <a href="{{ route('vue.liste.demande.attestation') }}" class="nav-link">
            <i class="fa-solid fa-magnet"></i>
            Mes attestations 
        </a>
      </li>
      <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa-solid fa-folder-open"></i>
            Mes guides et FAQ  
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('guide.index') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              Guide
            </a>
            <a href="{{ route('faq.index') }}" class="nav-link">
              <i class="fa-solid fa-calendar-days"></i>
              FAQ
            </a>
          </div>
      </li>
      <!-- <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa-solid fa-folder-open"></i>
            Documents
          </a>
          <div class="dropdown-menu">
            <a href="/liste/de/document" class="nav-link">
              <i class="fa-solid fa-folder-open"></i>
                Liste des documents
            </a>
          </div>
      </li> -->
      <!-- <li class="nav-item">
        <a href="" class="nav-link">
            <i class="fa-brands fa-leanpub"></i>
            Formation
        </a>
      </li> -->
      <!-- <li class="nav-item">
        <a href="/liste/de/mon/annuaire" class="nav-link" >
        <i class="fa-solid fa-address-card"></i>
            Annuaire
        </a>
      </li>
      @admin
      <li class="nav-item">
        <a href="{{route('vue.liste.salle')}}" class="nav-link" >
        
        <i class="fa-solid fa-compass"></i>
            Salle barreau 
        </a>
      </li>
      @endadmin -->
    </ul>

  </aside><!-- End Sidebar-->