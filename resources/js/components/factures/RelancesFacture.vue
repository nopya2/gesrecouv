<template>
    <div>
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title">
                    Relances
                    <span class="badge badge-dark">{{relaunches.length}}</span>
                </h3>
                <div class="card-tools">
                    <button
                        @click="showModal"
                        type="button" 
                        class="btn btn-info btn-sm">
                        <i class="fas fa-redo mr-1"></i> Relancer
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0 scrollable">
                <p v-if="relaunches.length <= 0" class="p-2 text-center text-muted">Aucune relance</p>
                <ul class="list-group">
                    <li class="list-group-item"
                        v-for="(item, index) in relaunches" :key="index">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fas text-muted mx-2" 
                                    :class="[formatIcon(item.mode_relaunch)]"
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    :title="item.mode_relaunch"></i>
                            </div>
                            <div class="col-md-2 text-muted text-sm italic">
                                <em>{{item.created_at|moment("DD/MM/YYYY H:m")}}</em>
                            </div>
                            <div class="col-md-6">
                                <span v-html="item.comment"></span>
                            </div>
                            <div class="col-md-2 text-muted text-sm italic">
                                <em>{{item.user.name}} {{item.user.firstname}}</em>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-outline-danger btn-xs border-0 float-right"
                                    @click="removeRelaunch(item)"
                                    title="Supprimer">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="modal fade" id="modal-relaunch-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Relancer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label>Mode de ralance</label>
                                <select class="form-control"
                                    v-model="$v.relaunch.mode_relaunch.$model">
                                    <option :value="''">--- Sélectionnez un mode ---</option>
                                    <option v-for="(item, index) in modes_relaunch" :key="index">{{item.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Commentaires</label>
                                <textarea 
                                    class="form-control" 
                                    rows="5" 
                                    v-model="$v.relaunch.comment.$model"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                            class="btn btn-success" 
                            :disabled="$v.relaunch.$invalid"
                            ref="submit"
                            @click="saveRelaunch"
                            v-if="!btnLoading">Enregistrer</button>
                        <button class="btn btn-primary shadow-2"
                            type="button"
                            disabled=""
                            v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...</button>
                    </div>
                </div>
            </div>
        </div>   
    
    </div>
    
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs } from 'vuelidate/lib/validators';
    import Relaunch from './../../models/relaunch'

    export default {
        name: 'RelancesFacture',
        props : ['facture_id'],
        mounted() {
            var vm = this
            $('#modal-relaunch-form').on('hidden.bs.modal', function (e) {
                vm.relaunch = new Relaunch()
            })
            $('[data-toggle="tooltip"]').tooltip()
        },

        data(){
            return{
                relaunches: [],
                relaunch: new Relaunch(),
                modes_relaunch: [
                    {name: 'Appel Téléphonique', icon: 'fa-phone'},
                    {name: 'Email', icon: 'fa-at'},
                    {name: 'Courrier Postal', icon: 'fa-mail-bulk'},
                    {name: 'Fax', icon: 'fa-fax'}],
                btnLoading: false,
                icons: [''],
                selectedRelaunch: null
            }
        },
        validations: {
            relaunch: {
                mode_relaunch: {
                    required,
                    minLength: minLength(3)
                },
                comment: {
                    required,
                    minLength: minLength(3)
                },
            }
        },

        created(){
            this.getRelaunches()
        },

        methods: {
            showModal(){
                $('#modal-relaunch-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeModal(){
                $('#modal-relaunch-form').modal('hide')
            },
            getRelaunches(){
                var vm = this
                axios.get(`/api/factures/${this.facture_id}/relaunches`)
                    .then((response)=> {
                        vm.relaunches = response.data.data
                    }).catch((error)=>{
                        toastr.error('Erreur chargement des relances!')
                    })
            },
            saveRelaunch(){
                var vm = this
                vm.btnLoading = true

                axios.patch(`/api/factures/${this.facture_id}/relaunch`, vm.relaunch)
                    .then((response)=> {
                        // vm.relaunches.unshift(vm.relaunch)
                        vm.getRelaunches()
                        vm.btnLoading = false
                        vm.closeModal()
                        toastr.success('Facture relancée!')

                    }).catch((error)=>{
                        vm.btnLoading = false
                        toastr.error('Erreur relance!')
                    })
            },
            removeRelaunch(relaunch){
                var vm = this
                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir retire cette relance?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/relaunches/${relaunch.id}`)
                            .then(response => {
                                return response
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Echec de la requête: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        var index = vm.relaunches.findIndex(x => x.id == relaunch.id)
                        if(index !== -1) vm.relaunches.splice(index, 1)
                    }
                }).catch((error)=>{
                    toastr.error('Erreur suppression relance!')
                })
                
            },
            formatIcon(mode){
                var index = this.modes_relaunch.findIndex(x => x.name == mode)
                if(index != -1) return this.modes_relaunch[index].icon
                else return 'fa-comment'
            }
        }

    }
</script>

<style scoped>
    .scrollable{
        overflow-y: auto; 
        max-height: 300px;
        /* min-height: 150px; */
    }
</style>
