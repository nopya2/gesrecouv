<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-4" v-if="modifier">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-warning" @click="editEngagement" :disabled="engagement.cancelled == true">
                        <i class="fas fa-edit mr-1"></i>Modifier l'engagement
                    </button>
                    <button type="button" class="btn btn-danger" @click="annulerEngagement(engagement)" :disabled="engagement.is_paid || engagement.cancelled == true">
                        <i class="fas fa-times mr-1"></i>Annuler l'engagement
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Détails de l'engagement</h3>
                            <div class="card-tools" v-if="engagement.cancelled == true">
                                <span data-toggle="tooltip" title="Engagement annulé" class="badge badge-danger">Engagement annulé</span>
                            </div>
                        </div>
                        <div class="card-body" style="max-height: 600px; overflow: scroll">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Montant engagé</label>
                                        <input type="text" class="form-control bg-info" readonly :value="engagement.m_engage|numFormat">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Montant payé</label>
                                        <input type="text" class="form-control bg-success" readonly :value="engagement.m_paye|numFormat">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Montant non payé</label>
                                        <input type="text" class="form-control bg-warning" readonly :value="engagement.m_non_paye|numFormat">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Exercice</label>
                                        <input type="text" class="form-control" readonly :value="engagement.d_exerci">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nature dépense</label>
                                        <input type="text" class="form-control" readonly :value="engagement.nat_dep">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Libellé imputation budgétaire</label>
                                        <input type="text" class="form-control" readonly :value="engagement.l_dep">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>N° engagement</label>
                                        <input type="text" class="form-control" readonly :value="engagement.n_engage">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date paiement</label>
                                        <input type="text" class="form-control" readonly :value="engagement.date_paiement|moment('DD/MM/YYYY')" v-if="engagement.date_paiement">
                                        <input type="text" class="form-control" readonly :value="'N/A'" v-if="!engagement.date_paiement">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date dépot AC</label>
                                        <input type="text" class="form-control" readonly :value="engagement.date_depot_ac|moment('DD/MM/YYYY')" v-if="engagement.date_depot_ac">
                                        <input type="text" class="form-control" readonly :value="'N/A'" v-if="!engagement.date_depot_ac">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date engagement</label>
                                        <input type="text" class="form-control" readonly :value="engagement.d_engage|moment('DD/MM/YYYY')" v-if="engagement.d_engage">
                                        <input type="text" class="form-control" readonly :value="'N/A'" v-if="!engagement.d_engage">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Libellé dépense</label>
                                        <input type="text" class="form-control" readonly :value="engagement.l_depeng">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fournisseur</label>
                                        <input type="text" class="form-control" readonly :value="engagement.l_nmtir">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>N° matricule</label>
                                        <input type="text" class="form-control" readonly :value="engagement.n_mattir">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Code matricule</label>
                                        <input type="text" class="form-control" readonly :value="engagement.c_mattir">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Chapitre</label>
                                        <input type="text" class="form-control" readonly :value="engagement.l_chap">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Devis/Facture</label>
                                        <input type="text" class="form-control" readonly :value="engagement.n_devis">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Tableau des OP</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success btn-sm" @click="openPaiementForm"
                                            :disabled="engagement.m_engage <= 0"
                                        v-if="payer">
                                        <i class="fa fa-plus"></i> &nbsp;Ajouter OP
                                    </button>
                                    <span class="text-danger" v-if="engagement.m_engage <= 0">
                                <small>Vous ne pouvez pas effectuer de paiements, aucun montant n'est engagé!</small>
                            </span>
                                </div>
                            </div>

                            <div class="table-border-style">
                                <div class="d-flex justify-content-center mb-3" v-if="spinner">
                                    <div class="spinner-grow text-warning" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example1">
                                        <thead>
                                        <tr style="text-align: center;">
                                            <th>#</th>
                                            <th>Etat</th>
                                            <th>N° ordonnance</th>
                                            <th>Montant payé</th>
                                            <th>Date paiement</th>
                                            <th>Date dépot AC</th>
                                            <th>Pièces jointes</th>
                                            <th>Commentaire</th>
                                        </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                        <tr v-if="echelons.length <= 0">
                                            <td colspan="8">Aucun paiement</td>
                                        </tr>
                                        <tr v-for="(echelon, index) in echelons" v-bind:key="echelon.id">
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        :disabled="!annuler && !valider">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item text-secondary" href="#" v-if="echelon.etat == 'validated' || echelon.etat == 'cancelled'">Aucune action</a>
                                                        <a class="dropdown-item text-success" href="#" @click="openValidateForm(echelon)" v-if="echelon.etat == 'waiting' && valider">Valider</a>
                                                        <a class="dropdown-item text-danger" href="#" @click="annulerPaiement(echelon)" v-if="echelon.etat == 'waiting' && annuler">Annuler</a>
                                                        <!--<a class="dropdown-item" href="#">Something else here</a>-->
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="echelon.etat == 'waiting'" class="right badge badge-secondary">En attente <br>de validation</span>
                                                <span v-if="echelon.etat == 'validated'" class="right badge badge-success">Validé</span>
                                                <span v-if="echelon.etat == 'cancelled'" class="right badge badge-danger">Annulé</span>
                                            </td>
                                            <td>{{ echelon.n_ordonnance }}</td>
                                            <td>{{ echelon.m_paye|numFormat }}</td>
                                            <td>
                                                <span v-if="echelon.date_paiement">{{ echelon.date_paiement|moment('DD/MM/YYYY') }}</span>
                                                <span v-if="!echelon.date_paiement">N/A</span>
                                            </td>
                                            <td>
                                                <span v-if="echelon.date_depot_ac">{{ echelon.date_depot_ac|moment('DD/MM/YYYY') }}</span>
                                                <span v-if="!echelon.date_depot_ac">N/A</span>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li v-for="document in echelon.documents">
                                                        {{ document.filename }}
                                                        <a :href="`/uploads/documents/${document.filename}`" target="_blank">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>{{ echelon.comment }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ajouter paiement</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeImport">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>N° Ordonnance</label>
                                                        <input type="text" class="form-control" name="m_paye" v-model="$v.echelon.n_ordonnance.$model"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Montant payé</label>
                                                        <input type="number" class="form-control" name="m_paye" v-model="$v.echelon.m_paye.$model"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date paiement</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask ref="date_paiement_0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date dépot AC</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask ref="date_depot_ac">
                                                        </div>
                                                    </div>
                                                </div>
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
                                                        <button class="btn btn-outline-danger btn-xs" @click="removeDocument(document)">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-success btn-xs" @click="addDocument" v-if="documents.length <= 5">
                                                    Ajouter une pièce jointe
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <label>Commentaire</label>
                                                <textarea rows="4" class="form-control" name="comment" v-model.trim="$v.echelon.comment.$model"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeImport">Annuler</button>
                                            <button type="button" class="btn btn-success" :disabled="$v.echelon.$invalid" @click="addPaiement" v-if="!btnLoading">Ajouter</button>
                                            <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                                                <span class="spinner-grow spinner-grow-sm" role="status"></span>
                                                Traitement...
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            <div class="modal fade" id="modal-edit">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Modifier l'engagement</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="realized" v-model="engagement_form.realized">
                                                    <label for="realized">
                                                        Effective?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Commentaire</label>
                                                <textarea class="form-control" v-model.trim="$v.engagement_form.commentaire.$model" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                            <button type="button" class="btn btn-warning" :disabled="$v.engagement_form.$invalid"
                                                    @click="saveEngagement" v-if="!btnLoadingSaveEngagement">Enregistrer</button>
                                            <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoadingSaveEngagement">
                                                <span class="spinner-grow spinner-grow-sm" role="status"></span>
                                                Enregistrement en cours...
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div> <!-- /.modal-edit -->

                            <!-- Modal valider paiement -->
                            <div class="modal fade" id="modal-validate-paiement">
                                <div class="modal-dialog">
                                    <div class="modal-content modal-">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Valider Paiement</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>N° engagement</label>
                                                <input type="text" class="form-control" :value="selected_echelon.n_engage" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>N° ordonnance</label>
                                                <input type="text" class="form-control" :value="selected_echelon.n_ordonnance" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Date de paiement <small class="text-danger">(obligatoire)</small></label>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask ref="date_paiement">
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                            <button type="button" class="btn btn-success" :disabled="selected_echelon == ''" @click="validerPaiement" v-if="!btnLoading">Valider</button>
                                            <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                                                <span class="spinner-grow spinner-grow-sm" role="status"></span>
                                                Validation en cours...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./Modal valider paiement -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';

    export default {
        mounted() {
            // console.log('Component mounted.')
            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            $(function () {

            })
        },

        props : ['n_engage', 'engagement_id', 'modifier', 'payer', 'valider', 'annuler'],

        data(){
            return{
                engagement: {},
                echelons: [],
                echelon: {
                    m_paye: null,
                    date_paiement: null,
                    date_depot_ac: null,
                    n_engage: '',
                    comment: '',
                    n_ordonnance: ''
                },
                file: {},
                doc: {},
                documents: [],
                spinner: false,
                api_token: '',
                btnLoading: false,
                engagement_form: {
                    realized: false,
                    commentaire: ''
                },
                btnLoadingSaveEngagement: false,
                selected_echelon: {
                    date_paiement: null,
                    n_ordonnance: '',
                    n_engage: ''
                },

            }
        },
        validations: {
            echelon: {
                m_paye: {
                    required,
                    maxValue
                },
                date_paiement: {
                    // required
                },
                date_depot_ac: {
                    // required
                },
                comment: {
                    // required
                },
                n_ordonnance: {
                    required
                }
            },
            engagement_form: {
                commentaire: {
                    // required,
                }
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchEngagement()
                this.fetchEchelons()
                this.addDocument()
            }

            this.echelon.n_engage = this.n_engage

        },

        methods: {
            fetchEngagement(page_url){
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/engagements/${this.engagement_id}?api_token=${this.api_token}&n_engage=${this.n_engage}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.engagement = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            },
            fetchEchelons(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/echelons/select-by-engagement-number?api_token=${this.api_token}&n_engage=${this.n_engage}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.echelons = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            },
            openPaiementForm(){
                this.echelon.m_paye = this.engagement.m_engage
                if(this.engagement.date_depot_ac != null)
                    this.$refs.date_depot_ac.value = moment(this.engagement.date_depot_ac).format('DD/MM/YYYY')
                if(this.engagement.date_paiement != null)
                    this.$refs.date_paiement_0.value = moment(this.engagement.date_paiement).format('DD/MM/YYYY')
                // this.echelon.date_paiement = this.engagement.date_paiement
                // this.echelon.date_depot_ac =  this.engagement.date_depot_ac
                $('#modal-default').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeImport(){
                this.echelon.m_paye = null
            },
            addPaiement(){
                // this.echelon.date_paiement =  this.$refs.date_paiement.value
                this.echelon.date_depot_ac =  this.$refs.date_depot_ac.value;
                this.echelon.date_paiement =  this.$refs.date_paiement_0.value;

                this.btnLoading = true

                fetch(`/api/echelon?api_token=${this.api_token}`, {
                    method: 'post',
                    body: JSON.stringify(this.echelon),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {

                        if(this.documents[0].size > 0){
                            //Ensuite on upload les documents pour cette facture
                            let formData = new FormData()
                            $.each(this.documents, function(key, document){
                                if(document.size > 0) formData.append(`documents[${key}]`, document)
                            });
                            formData.append('echelon', res.data.id)

                            fetch(`/api/echelon/upload-files?api_token=${this.api_token}`, {
                                method: 'post',
                                body: formData
                            })
                                .then(res => res.json())
                                .then(res => {
                                    this.btnLoading = false
                                    $('#modal-default').modal('hide')
                                    toastr.success('OP ajoutée!')
                                    this.fetchEngagement()
                                    this.fetchEchelons()
                                    this.echelon.m_paye = null

                                })
                                .catch(error => {
                                    this.btnLoading = false
                                    toastr.error('Erreur upload de fichiers!.')
                                });
                        }else{
                            this.btnLoading = false
                            $('#modal-default').modal('hide')
                            toastr.success('paiement ajouté!')
                            this.fetchEngagement()
                            this.fetchEchelons()
                            this.echelon.m_paye = null
                        }

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur import du fichier!.')
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
            editEngagement(){
                this.engagement_form.realized = this.engagement.realized
                this.engagement_form.commentaire = this.engagement.commentaire
                $('#modal-edit').modal({
                    show: true,
                    // backdrop: 'static'
                })
            },
            saveEngagement(){
                this.btnLoadingSaveEngagement = true
                let data = {
                    id: this.engagement.id,
                    realized: this.engagement_form.realized,
                    commentaire: this.engagement_form.commentaire
                }

                fetch(`/api/engagements?api_token=${this.api_token}`, {
                    method: 'put',
                    body: JSON.stringify(data),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.btnLoadingSaveEngagement = false
                        this.engagement = {...res.data}
                        toastr.success('Informations enregistrées!')
                    })
                    .catch(error => {
                        this.btnLoadingSaveEngagement = false
                        toastr.error('Erreur import du fichier!.')
                    });
            },
            openValidateForm(echelon){
                this.selected_echelon = {...echelon}
                $('#modal-validate-paiement').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            validerPaiement(){
                this.selected_echelon.date_paiement =  this.$refs.date_paiement.value
                let vm = this;
                vm.btnLoading = true

                fetch(`/api/echelon/valider?api_token=${this.api_token}`, {
                    method: 'post',
                    body: JSON.stringify(this.selected_echelon),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        vm.btnLoading = false
                        toastr.success('OP validée!')
                        let index = vm.echelons.findIndex(x => x.id === vm.selected_echelon.id)
                        if(index !== -1){
                            vm.echelons.splice(index, 1, res.data)
                        }
                        vm.engagement = {...res.data.engagement}
                        $('#modal-validate-paiement').modal('hide')

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur validation!.')
                    });
            },
            annulerPaiement(echelon){
                let vm = this;

                Swal.fire({
                    title: 'Annuler',
                    text: 'Etes-vous sur de vouloir annuler cette OP?',
                    showCancelButton: true,
                    confirmButtonText: 'Annuler OP',
                    cancelButtonText: 'Fermer',
                    confirmButtonColor: '#DC3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/echelon/annuler?api_token=${this.api_token}`, {
                            method: 'post',
                            body: JSON.stringify(echelon),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
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
                        toastr.error('OP annulée!')
                        let index = vm.echelons.findIndex(x => x.id === echelon.id)
                        if(index !== -1){
                            console.log(index)
                            vm.echelons.splice(index, 1, result.value.data)
                        }
                    }
                })
            },
            annulerEngagement(engagement){
                let vm = this;

                Swal.fire({
                    title: 'Annuler',
                    text: 'Etes-vous sur de vouloir annuler cet engagement?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    cancelButtonText: 'Fermer',
                    confirmButtonColor: '#DC3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/engagements/cancel?api_token=${this.api_token}`, {
                            method: 'put',
                            body: JSON.stringify(engagement),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
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
                        toastr.warning('Engagement annulé!')
                        this.engagement = {...result.value.data}
                    }
                })
            }
        }

    }
</script>

<style>
    .form-control[readonly] {
        background-color: white;
        opacity: 1;
    }
</style>
