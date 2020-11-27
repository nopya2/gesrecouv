<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="createModule()">
                    <i class="fa fa-plus-circle"></i> Ajouter un module
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
                            <th>Nom court</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="modules.length <= 0">
                            <td colspan="4" class="text-center">Aucun module trouvé</td>
                        </tr>
                        <tr v-for="(item, index) in modules" v-bind:key="index">
                            <!-- <td>{{ group.id }}</td> -->
                            <td class="vertical-align">{{ item.name }}</td>
                            <td class="vertical-align">{{ item.slug }}</td>
                            <td class="vertical-align">{{ item.description }}</td>
                            <td class="vertical-align">
                                <span v-if="item.permissions <= 0">Aucune permission</span>
                                <button type="button" class="btn btn-xs btn-link float-right" 
                                    @click="addPermission(item.id)"
                                    data-toggle="tooltip" data-placement="bottom" title="Ajouter une permission">
                                    <i class="fas fa-plus text-success"></i>
                                </button>
                                <br>
                                <ul>
                                    <li v-for="permission in item.permissions" :key="permission.id">
                                        {{permission.name}} 
                                        <button type="button" class="btn btn-xs btn-link ml-1" 
                                            @click="deletePermission(item.id, permission.id)"
                                            data-toggle="tooltip" data-placement="bottom" title="Retirer la permission du module">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </li>
                                </ul>
                            </td>
                            <td class="vertical-align text-center">
                                <button type="button" class="btn btn-warning btn-icon btn-xs" title="Modifier" @click="editModule(item)">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" title="Supprimer" @click="deleteModule(item.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>Nom</th>
                        <th>Nom court</th>
                        <th>Description</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchModules(pagination.prev_page_url)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page}}</a></li>
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchModules(pagination.next_page_url)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal Creer module -->
        <div class="modal fade" id="modal-module-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ module_form.title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModuleForm">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="Entrez le nom" v-model.trim="$v.module_form.name.$model">
                            </div>
                            <div class="form-group">
                                <label for="slug">Nom court <small class="text-muted text-sm"><i>ex: facturation</i></small></label>
                                <input class="form-control" id="slug" placeholder="Entrez le nom court" v-model.trim="$v.module_form.slug.$model">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.module_form.description.$model"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModuleForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.module_form.$invalid" @click="saveModule" v-if="!btnLoading && module_form.action =='create'">Créer</button>
                        <button type="button" class="btn btn-warning" :disabled="$v.module_form.$invalid" @click="updateModule" v-if="!btnLoading && module_form.action =='update'">Modifier</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal Creer module -->

        <!-- Modal ajouter permission -->
        <div class="modal fade" id="modal-permission-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter permission</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="Entrez le nom" v-model.trim="$v.permission_form.name.$model">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.permission_form.description.$model"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.permission_form.$invalid" @click="savePermission" v-if="!btnPermissionLoading">Ajouter</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnPermissionLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal ajouter permission -->
    </div>
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';

    export default {
        mounted() {
            $('[data-toggle="tooltip"]').tooltip()
            let vm = this
            $('#modal-permission-form').on('hidden.bs.modal', function (e) {
                vm.selectedModuleId = null
                vm.permission_form = {
                    name: '',
                    description: '',
                }
            })
        },

        data(){
            return{
                modules: [],
                module_form: {
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
                permission_form: {
                    name: '',
                    description: '',
                },
                btnPermissionLoading: false,
                selectedModuleId: null

            }
        },
        validations: {
            module_form: {
                name: {
                    required,
                },
                description: {
                    required
                },
                slug: {
                    required
                }
            },
            permission_form: {
                name: {
                    required,
                },
                description: {
                    required
                }
            }
        },

        created(){
            this.fetchModules()
        },

        methods: {
            fetchModules(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/modules?keyword=${this.keyword}&limit=15`
                axios.get(page_url)
                    .then(res => {
                        this.spinner = false
                        this.modules = res.data.data
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
                this.fetchModules();
            },
            deleteModule(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer ce module?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/modules/${id}?`)
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
                        vm.fetchModules();
                    }
                })
            },
            openModuleForm(){
                $('#modal-module-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeModuleForm(){
                $('#modal-module-form').modal('hide')
                this.module_form = {
                    id: '',
                    name: '',
                    description: '',
                    title: '',
                    action: ''
                }
            },
            createModule(){
                this.module_form.title = `Créer un module`
                this.module_form.action = `create`
                this.openModuleForm()
            },
            saveModule(){
                this.btnLoading = true

                axios.post(`/api/modules`, this.module_form)
                    .then(res => {

                        this.btnLoading = false
                        this.closeModuleForm()
                        toastr.success('Module créé!')
                        this.fetchModules()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur création du module!')
                    });
            },
            updateModule(){
                let vm = this
                vm.btnLoading = true

                axios.patch(`/api/modules`, vm.module_form)
                    .then(res => {
                        let index = vm.modules.findIndex(x => x.id ===vm.module_form.id)
                        if(index != -1){
                            vm.modules[index] = res.data.data
                        }
                        vm.btnLoading = false
                        vm.closeModuleForm()
                        toastr.warning('Modifications engregistrées!')

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur modificaion du module!')
                    });
            },
            editModule(module){
                this.module_form = {...module}
                this.module_form.title = `Modifier le module [${module.id}]`
                this.module_form.action = "update"
                this.openModuleForm()
            },
            addPermission(moduleId){
                $('#modal-permission-form').modal({
                    show: true,
                    backdrop: 'static'
                })

                this.selectedModuleId = moduleId
            },
            savePermission(){
                let vm = this
                this.btnLoading = true

                axios.post(`/api/modules/${this.selectedModuleId}/add-permission`, vm.permission_form)
                    .then(res => {
                        let index = vm.modules.findIndex(x => x.id ===vm.selectedModuleId)
                        if(index != -1){
                            vm.modules[index] = res.data.data
                        }
                        vm.btnLoading = false
                        $('#modal-permission-form').modal('hide')
                        toastr.success('Permission ajoutée!')

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur ajout de la permission!')
                    });
            },
            deletePermission(moduleId, permissionId){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir retirer cette permission du module?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/modules/${moduleId}/delete-permission?permission=${permissionId}`)
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
                        let index = vm.modules.findIndex(x => x.id ===moduleId)
                        if(index != -1){
                            vm.modules[index] = result.value.data.data
                        }
                        this.$forceUpdate();
                        toastr.warning('Permission retirée!')
                    }
                })
            },

        }

    }
</script>
