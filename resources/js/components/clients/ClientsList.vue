<template>
    <div class="card-block table-border-style">
        <div class="row">
            <div class="col-md-6">
                <a v-bind:href="'/clients/create'">
                    <button class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Créer un client
                    </button>
                </a>
                <button class="btn btn-secondary btn-sm">
                    <i class="fas fa-print"></i> Imprimer
                </button>
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Exporter excel
                </button>
            </div>
            <div class="col-md-3 offset-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Tapez votre recherche, raison sociale ou NIF" v-model="filter.keyword" v-on:keyup="search">
            </div>
        </div>

        <div class="table-border-style mt-3">
            <div class="d-flex justify-content-center mb-3" v-if="spinner">
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                    <tr class="text-center">
                        <th>Raison sociale</th>
                        <th>NIF</th>
                        <th>Type</th>
                        <!-- <th>Téléphone</th> -->
                        <th>Ville</th>
                        <!-- <th>Adresse</th> -->
                        <th>Responsable</th>
                        <th>Téléphone responsable</th>
                        <th>E-mail</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody style="font-size: 14px">
                    <tr>
                        <td colspan="8" v-if="clients.length <= 0">
                            Aucun client trouvé
                        </td>
                    </tr>
                    <tr v-for="client in clients" :key="client.id">
                        <td>{{ client.raison_sociale }}</td>
                        <td class="text-center">{{ client.nif }}</td>
                        <td>{{ client.type }}</td>
                        <td>{{ client.ville }}</td>
                        <td>{{ client.responsable }}</td>
                        <td>{{ client.tel_responsable }}</td>
                        <td>{{ client.email }}</td>
                        <td class="text-center">
                            <a :href="'clients/'+client.id">
                                <button class="btn btn-info btn-icon btn-xs" title="Détails">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>
                            <a :href="'clients/'+client.id+'/edit'">
                                <button class="btn btn-warning btn-icon btn-xs" title="Modifier">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <button class="btn btn-icon btn-danger btn-xs" title="Supprimer" @click="deleteClient(client.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="text-center">
                        <th>Raison sociale</th>
                        <th>NIF</th>
                        <th>Type</th>
                        <!-- <th>Téléphone</th> -->
                        <th>Ville</th>
                        <!-- <th>Adresse</th> -->
                        <th>Responsable</th>
                        <th>Téléphone responsable</th>
                        <th>E-mail</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row" v-if="clients.length > 0">
                <div class="col-md-6">
                    De {{ pagination.from }} à {{ pagination.to }} sur {{ pagination.total }} Clients
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                                <a class="page-link" href="javascript:" tabindex="-1" @click="fetchClients(pagination.prev_page_url)">Précédent</a>
                            </li>
                            <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                            <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                            <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                            <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                                <a class="page-link" href="javascript:" @click="fetchClients(pagination.next_page_url)">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {

        props : [],

        data(){
            return{
                clients: [],
                filter: {
                    keyword: '',
                },
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                spinner: true,

            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchClients()
            }

        },

        methods: {
            fetchClients(page) {
                let vm = this;
                this.spinner = true;

                let url_parameters = `api_token=${this.api_token}&keyword=${this.filter.keyword}&limit=15`
                let page_url = `/api/clients?${url_parameters}`
                if(page) page_url = `${page}&${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.clients = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    total: meta.total,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    from: meta.from,
                    to: meta.to
                }

                this.pagination = pagination;
            },
            search(){
                this.fetchClients();
            },
            deleteClient(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/clients/${id}?api_token=${this.api_token}`, { method: 'delete' })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        toastr.warning('Suppression terminée!.')
                        vm.fetchClients();
                    }
                })
            }
        }

    }
</script>
