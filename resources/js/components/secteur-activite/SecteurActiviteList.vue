<template>
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card-block table-border-style">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-sm" @click="createSecteur()">
                            <i class="fa fa-plus-circle"></i> Ajouter un secteur d'activité
                        </button>
                    </div>
                    <div class="col-md-4 offset-md-2">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="validationTooltipUsernamePrepend">
                                    <span class="badge badge-pill badge-primary">{{ pagination.total }}</span>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Tapez votre recherche" aria-label="Recipient's groupname"
                                aria-describedby="basic-addon2" v-model="keyword" v-on:keyup="search">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="feather icon-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-border-style">
                    <div class="d-flex justify-content-center mb-3" v-if="spinner">
                        <div class="spinner-grow text-warning" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover projects" id="example1">
                            <thead>
                                <tr style="text-align: center;">
                                    <!-- <th>#</th> -->
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="secteurs.length <= 0">
                                    <td colspan="4" class="text-center">Aucun secteur d'activité trouvé</td>
                                </tr>
                                <tr v-for="(item, index) in secteurs" v-bind:key="index">
                                    <!-- <td>{{ group.id }}</td> -->
                                    <td class="vertical-align">{{ item.name }}</td>
                                    <td class="vertical-align">{{ item.description }}</td>
                                    <td class="vertical-align text-center">
                                        <button type="button" class="btn btn-warning btn-icon btn-xs" title="Modifier" @click="editSecteur(item)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-danger btn-xs" title="Supprimer" @click="deleteSecteur(item.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr style="text-align: center;">
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                                    <a class="page-link" href="javascript:" tabindex="-1" @click="fetchSecteurs(pagination.prev_page_url)">Précédent</a>
                                </li>
                                <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page}}</a></li>
                                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                                    <a class="page-link" href="javascript:" @click="fetchSecteurs(pagination.next_page_url)">Suivant</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>

                <!-- Modal Creer Secteur -->
                <div class="modal fade" id="modal-secteur-form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ secteur_form.title }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeSecteurForm">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="name">Nom</label>
                                        <input type="text" class="form-control" id="name" placeholder="Entrez le nom" v-model.trim="$v.secteur_form.name.$model">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.secteur_form.description.$model"></textarea>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeSecteurForm">Annuler</button>
                                <button type="button" class="btn btn-success" :disabled="$v.secteur_form.$invalid" @click="saveSecteur" v-if="!btnLoading && secteur_form.action =='create'">Créer</button>
                                <button type="button" class="btn btn-warning" :disabled="$v.secteur_form.$invalid" @click="updateSecteur" v-if="!btnLoading && secteur_form.action =='update'">Modifier</button>
                                <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                                    <span class="spinner-grow spinner-grow-sm" role="status"></span>
                                    Traitement en cours...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Modal Creer secteur -->
            </div>
        </div>
    </div>
    
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';

    export default {
        mounted() {
        },

        data(){
            return{
                secteurs: [],
                secteur_form: {
                    id: null,
                    name: '',
                    description: '',
                    action: 'create',
                    title: ''
                },
                title: '',
                description: '',
                keyword: '',
                spinner: false,
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                btnLoading: false,
                selectedSecteurId: null

            }
        },
        validations: {
            secteur_form: {
                name: {
                    required,
                },
                description: {},
            },
        },

        created(){
            this.fetchSecteurs()
        },

        methods: {
            fetchSecteurs(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/secteurs-activites?keyword=${this.keyword}&limit=15`
                axios.get(page_url)
                    .then(res => {
                        this.spinner = false
                        this.secteurs = res.data.data
                        vm.makePagination(res.data.meta, res.data.links)
                    })
                    .catch(error => {
                        console.log(error)
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
                this.fetchSecteurs();
            },
            deleteSecteur(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer ce secteur?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/secteurs-activites/${id}?`)
                            .then(response => {
                                return response
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
                        vm.fetchSecteurs();
                    }
                })
            },
            openSecteurForm(){
                $('#modal-secteur-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeSecteurForm(){
                $('#modal-secteur-form').modal('hide')
                this.secteur_form = {
                    id: '',
                    name: '',
                    description: '',
                    title: '',
                    action: ''
                }
            },
            createSecteur(){
                this.secteur_form.title = `Créer un secteur`
                this.secteur_form.action = `create`
                this.openSecteurForm()
            },
            saveSecteur(){
                this.btnLoading = true

                axios.post(`/api/secteurs-activites`, this.secteur_form)
                    .then(res => {

                        this.btnLoading = false
                        this.closeSecteurForm()
                        toastr.success('Secteur créé!')
                        this.fetchSecteurs()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur création du secteur!')
                    });
            },
            updateSecteur(){
                let vm = this
                vm.btnLoading = true

                axios.patch(`/api/secteurs-activites`, vm.secteur_form)
                    .then(res => {
                        let index = vm.secteurs.findIndex(x => x.id ===vm.secteur_form.id)
                        if(index != -1){
                            vm.secteurs[index] = res.data.data
                        }
                        vm.btnLoading = false
                        vm.closeSecteurForm()
                        toastr.warning('Modifications engregistrées!')

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur modificaion du secteur!')
                    });
            },
            editSecteur(secteur){
                this.secteur_form = {...secteur}
                this.secteur_form.title = `Modifier le secteur [${secteur.id}]`
                this.secteur_form.action = "update"
                this.openSecteurForm()
            },
        }

    }
</script>
