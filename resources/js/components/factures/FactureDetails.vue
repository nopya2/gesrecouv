<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Facture n° {{ facture.num_facture }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Montant facturé</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ facture.montant|numFormat }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Montant payé</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ facture.m_paid|numFormat }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Reste à recouvrer</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ facture.m_not_paid|numFormat }}<span></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-muted">
                            <div class="col-md-4">
                                <p class="">Statut
                                    <b class="d-block">Deveint Inc</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Client
                                    <b class="d-block" v-if="facture.client != null">{{ facture.client.raison_sociale }}</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Facture parent
                                    <b class="d-block" v-if="facture.parent != null">{{ facture.parent.num_facture }}</b>
                                    <b class="d-block" v-if="facture.parent == null">N/A</b>
                                </p>
                            </div>
                        </div>
                        <div class="row text-muted">
                            <div class="col-md-4">
                                <p class="">Type de facture
                                    <b class="d-block" v-if="facture.type != null">{{ facture.type.libelle}}</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">N° Dossier
                                    <b class="d-block">{{ facture.num_dossier}}</b>
                                    <b class="d-block" v-if="facture.num_dossier == null">N/A</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Date de création
                                    <b class="d-block">{{ facture.date_creation | moment("DD/MM/YYYY") }}</b>
                                </p>
                            </div>
                        </div>
                        <div class="row text-muted">
                            <div class="col-md-4">
                                <p class="">Date de dépot
                                    <b class="d-block">{{ facture.date_depot | moment("DD/MM/YYYY") }}</b>
                                    <b class="d-block" v-if="facture.date_depot == null">N/A</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Date de paiement
                                    <b class="d-block">{{ facture.date_paiement | moment("DD/MM/YYYY") }}</b>
                                    <b class="d-block" v-if="facture.date_paiement == null">N/A</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Date d'échéance
                                    <b class="d-block">{{ facture.date_echeance | moment("DD/MM/YYYY") }}</b>
                                    <b class="d-block" v-if="facture.date_echeance == null">N/A</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-card-gray">
                    <div class="card-header">
                        <h3 class="card-title">Historique des paiements</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" @click="showPaiementForm()" v-if="facture.m_not_paid > 0"><i class="fas fa-plus mr-1"></i> Ajouter</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Montant</th>
                                    <th>Mode paiement</th>
                                    <th>Date paiement</th>
                                    <th>Pièces jointes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="paiements.length <=0" class="text-center">
                                    <td colspan="5">Aucun paiement</td>
                                </tr>
                                <tr v-for="item in paiements" :key="item.id">
                                    <td></td>
                                    <td>{{ item.montant }}</td>
                                    <td>{{ item.mode_paiement }}</td>
                                    <td>{{ item.date_paiement }}</td>
                                    <td>
                                        <ul>
                                            <li v-for="(document, index) in item.documents" :key="index">
                                                <a :href="`/uploads/documents/${document.filename}`" target="_blank">Document {{index+1}}</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Montant</th>
                                    <th>Mode paiement</th>
                                    <th>Date paiement</th>
                                    <th>Pièces jointes</th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                    <!-- <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal-paiement-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter un paiement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="libelle">Montant</label>
                                        <input type="number" class="form-control" v-model="$v.paiement.montant.$model">
                                        <small class="form-text text-danger" v-if="!$v.paiement.montant.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="libelle">Mode de paiement</label>
                                        <select class="form-control" v-model="$v.paiement.mode_paiement.$model">
                                            <option v-for="(item, index) in modes_paiement" :value="item.libelle" :key="index">{{ item.libelle }}</option>
                                            <small class="form-text text-danger" v-if="!$v.paiement.mode_paiement.required">Champs requis.</small>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="date_paiement">Date de paiement</label><br>
                                <date-picker
                                    v-model="$v.paiement.date_paiement.$model"
                                    value-type="format"
                                    format="YYYY-MM-DD"
                                    type="date"
                                    placeholder="Selectionnez une date"></date-picker>
                                <small class="form-text text-danger" v-if="!$v.paiement.date_paiement.required">Champs requis.</small>
                            </div>

                            <div class="form-group">
                                <label>Pièces jointes</label>
                                <div class="row mt-1" v-for="(document, index) in documents" :key="index">
                                    <div class="col-md-11">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" :ref="'file'+index" @change="handleFileUpload(document, index)">
                                            <label class="custom-file-label" for="customFile">{{ document.name }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1" v-if="documents.length > 1">
                                        <button type="button" class="btn btn-outline-danger btn-xs" @click="removeDocument(document)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-xs" @click="addDocument" v-if="documents.length <= 5">
                                    Ajouter une pièce jointe
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="commentaire">Commentaire</label>
                                <textarea class="form-control" id="commentaire" placeholder="Entrez un commentaire" v-model="$v.paiement.commentaire.$model"></textarea>
                                <small class="form-text text-danger" v-if="!$v.paiement.commentaire.required">Champs requis.</small>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closePaiementForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.paiement.$invalid" @click="savePaiement(paiement)" v-if="!btnLoading">Enregistrer</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Facture from './../../models/facture'
    import Paiement from './../../models/paiement'
    import FactureService from './../../services/factures'
    import ModePaiementService from './../../services/mode-paiement'
    import PaiementService from './../../services/paiement'
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import { required, minLength, maxLength, between, email, sameAs } from 'vuelidate/lib/validators';

    export default {

        props : ['facture_id'],
        mounted(){
            let vm = this
            $('#modal-paiement-form').on('hidden.bs.modal', function (e) {
                vm.paiement = new Paiement()
                vm.documents.forEach(item => {
                    vm.removeDocument(item)
                })
            })
            $('#modal-paiement-form').on('show.bs.modal', function (e) {
                vm.paiement.montant = vm.facture.m_not_paid
                vm.addDocument()
            })
        },
        data(){
            return{
                facture: new Facture(),
                paiements: [],
                paiement: new Paiement(),
                modes_paiement: [],
                documents: [],
                btnLoading: false,
            }
        },
        validations: {
            paiement: {
                montant: {
                    required
                },
                mode_paiement: {
                    required
                },
                date_paiement: {
                    required
                },
                commentaire: {
                    required
                }
            }
        },
        created(){

            this.fetchFacture(this.facture_id)
            this.fetchModes()
            this.addDocument()

        },

        methods: {

            fetchFacture(id){
                let vm = this

                FactureService.getFacture(id)
                    .then(res => res.json())
                    .then(res => {
                        vm.facture = res.data
                        vm.paiements = vm.facture.paiements

                    })
                    .catch(error => {
                        toastr.error('Erreur chargement de la facture!')
                    });
            },
            fetchModes() {
                let vm = this;

                ModePaiementService.getModes('')
                    .then(res => res.json())
                    .then(res => {
                        vm.modes_paiement = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des modes de paiement!')
                    });
            },
            showPaiementForm(){
                $('#modal-paiement-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closePaiementForm(){
                $('#modal-paiement-form').modal('hide')
            },
            savePaiement(paiement){
                let vm = this
                paiement.facture_id = this.facture.id
                paiement.facture = this.facture
                vm.btnLoading = true
                let formData = new FormData()
                formData.append('mode_paiement', paiement.mode_paiement)
                formData.append('date_paiement', paiement.date_paiement)
                formData.append('commentaire', paiement.commentaire)
                formData.append('facture_id', paiement.facture_id)
                formData.append('montant', paiement.montant)
                if(vm.documents[0].size > 0){
                    $.each(vm.documents, function(key, document){
                        if(document.size > 0) formData.append(`documents[${key}]`, document)
                    });
                }

                PaiementService.createPaiement(formData)
                    .then(res => res.json())
                    .then(res => {

                        vm.btnLoading = false
                        vm.closePaiementForm()
                        toastr.success('Paiement ajouté!')
                        vm.paiements.push(res.paiement)
                        vm.facture = res.facture

                    })
                    .catch(error => {
                        vm.btnLoading = false
                        toastr.error("Erreur enregistrement du paiement!")
                    });
            },
            addDocument(){
                this.documents.push(new File([""], "Veuillez sélectionnez un fichier"))
            },
            removeDocument(document){
                // this.documents.splice(index, 1)
                let index = this.documents.findIndex(x => x.name === document.name)
                this.documents.splice(index, 1);
                this.$forceUpdate();
            },
            handleFileUpload(document, index){
                if(this.$refs['file'+index][0].files[0]){
                    this.documents[index] = this.$refs['file'+index][0].files[0];
                    this.$forceUpdate();
                }
            },
        }

    }
</script>

<style scoped>

</style>
