<div class="mt-2">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Titre et bouton crée--}}
        <div class="flex justify-between items-center">
            
            <input wire:model="search" placeholder="Rechercher avec : nom ou prenom" type="text" class="block mt-2 border-gray-300 rounded-md">
            <div class="" style="">
                <a href="{{ route('admin') }}"  class="btn  btn-danger"><i class="fa fa-arrow-left"></i> Retour</a>
            </div>
            <a href="{{ route('admin.creer.utilisateur') }}" class="bg-blue-500 rounded-md p-2 text-white">
                {{ __("Faire une inscription") }}
            </a>
        </div>
        {{-- section message flash avec sweetAlert --}}
        @include('sweetalert::alert')
        @if(Session::get('success'))
            <div class="p-5">
                <div class="block p-2 bg-green-500 text-white rounded-sm shadow-sm mt-2"> {{ Session::get('success') }}</div>
            </div>
        @endif

       {{-- Stylisation du tableau --}}
       <div class="overflow-x-auto">
            <div class="py-4 inline-block min-w-full">
               <div class="overflow-hidden">
                    <table class="min-w-full text-center">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">N°</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Nom & prénom</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Email</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Date de naissance</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Sexe</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Tel</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Lieu Structure</th>
                                <th class="text-sm font-medium text-gray-900 px-6 py-6 text-black">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $id=1 @endphp
                            @forelse($listeUtilisateur as $item)
                                <tr class="border-b-2 border-gray-100">
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $id++ }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->name .' '. $item->prenom }} </th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->email }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->date_naissance }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->sexe }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->telephone }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->lieu_structure }}</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">
                                        <a href="{{ route('admin.liste.droit.details.utilisateur', $item->id) }}" class="p-1 rounded-sm bg-blue-400"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{ route('admin.vue.edition.droit.utilisateur', $item->id) }}" class="p-1 rounded-sm bg-blue-400"><i class="fa-solid fa-pencil"></i></a>
                                            <button data-confirm-delete="true" wire:click='supprimerUtilisateur({{ $item->id }})' class="p-1 rounded-sm bg-red-400"><i class="fa-solid fa-trash-can"></i></button>
                                    
                                    </th>
                                </tr>
                            @empty
                                <tr class="w-full">
                                    <td  class="flex-1 items-center justify-center"  colspan='10'>
                                        <div>
                                            <p class="flex justify-center content-center p-4">
                                                <img src="{{ asset('img/empty.svg') }}" alt="aucun élément trouvé en base de donnée."
                                                class="w-20 h-20">
                                                <div>Aucun élément trouvé !</div>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                   <div class="mt-3">
                        {{ $listeUtilisateur->links() }}
                   </div>
               </div>
            </div>
       </div>

    </div>
</div>
