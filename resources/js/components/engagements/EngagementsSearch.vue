<template>
    <div class="card-block table-border-style">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="debut" class="col-sm-2 col-form-label">Debut</label>
                            <div class="col-sm-8">
                                <select v-model="filter.year.start" class="form-control form-control-sm" @change="selectStart" id="debut">
                                    <option v-for="(year, index) in years" v-bind:value="year">{{ year }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="fin" class="col-sm-2 col-form-label">Fin</label>
                            <div class="col-sm-8">
                                <select v-model="filter.year.end" class="form-control form-control-sm" @change="selectEnd" id="fin">
                                    <option v-for="(year, index) in years" v-bind:value="year">{{ year }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fournisseur</label>
                            <select v-model="filter.provider" class="form-control form-control-sm">
                                <option value="">Tout</option>
                                <option v-for="(provider, index) in providers" v-bind:value="provider.name">{{ provider.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Statut</label>
                            <select v-model="filter.status" class="form-control form-control-sm">
                                <option value="">Tout</option>
                                <option value="paye">Payé</option>
                                <option value="paye_early">Payé à échéance</option>
                                <option value="paye_later">Payé en retard</option>
                                <option value="non_paye">Non Payé</option>
                                <option value="non_paye_later">Arrivé à échéance</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>N° facture ou devis</label>
                            <input type="text" class="form-control form-control-sm" v-model="filter.devis" placeholder="N° facture ou devis"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <button class="btn btn-info" @click="openFilter" title="Plus de filtres">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="btn btn-success" @click="search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="table-border-style">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center mb-3" v-if="spinner">
                        <div class="spinner-grow text-warning" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ pagination.total }} engagement(s)
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                    <tr style="text-align: center;">
                        <th>#</th>
                        <th title="Exercice">{{ 'Exercice' | truncate(20) }}</th>
                        <th title="Imputation Budgétaire">{{ 'Imputation Budgétaire' | truncate(20) }}</th>
                        <th title="Nature Dépense">{{ 'Nature Dépense' | truncate(20) }}</th>
                        <th title="Libellé Imputation Budgétaire">{{ 'Libellé Imputation Budgétaire' | truncate(20) }}</th>
                        <!-- <th>m_dispo</th> -->
                        <!-- <th>m_toteng</th> -->
                        <!-- <th>m_tengvi</th> -->
                        <!-- <th>m_totliq</th> -->
                        <!-- <th>m_tordvi</th> -->
                        <!-- <th>m_totord</th> -->
                        <!-- <th>m_dotini</th> -->
                        <th title="N° enagement">{{ 'N° enagement' | truncate(20) }}</th>
                        <th title="Montant engagé">{{ 'Montant engagé' | truncate(20) }}</th>
                        <th title="Date de dépôt Agence Comptable ANINF">{{ 'Date de dépôt Agence Comptable ANINF' | truncate(20) }}</th>
                        <th title="Date de paiements">{{ 'Date paiement' | truncate(20) }}</th>
                        <th title="Montant payé">{{ 'Montant payé' | truncate(20) }}</th>
                        <th title="Dates d’engagement">{{ 'Dates d’engagement' | truncate(20) }}</th>
                        <!-- <th>mois_</th> -->
                        <!-- <th>m_tliqenga</th> -->
                        <th title="Montants non payé">{{ 'Montants non payé' | truncate(20) }}</th>
                        <th title="Libellé de la dépense">{{ 'Libellé dépense' | truncate(20) }}</th>
                        <th title="Fournisseurs">{{ 'Fournisseurs' | truncate(20) }}</th>
                        <th title="N° matricule">{{ 'N° matricule' | truncate(20) }}</th>
                        <th title="Code matricule">{{ 'Code matricule' | truncate(20) }}</th>
                        <th title="Chapitre">{{ 'Chapitre' | truncate(20) }}</th>
                        <th title="N° devis (factures)">{{ 'N° devis (factures)' | truncate(20) }}</th>
                        <!-- <th>nip</th> -->
                        <th>Réengagement</th>
                    </tr>
                    </thead>
                    <tbody style="font-size: 14px">
                    <tr>
                        <td colspan="19" v-if="engagements.length <= 0">
                            Aucun engagement trouvé
                        </td>
                    </tr>
                    <tr v-for="(engagement, index) in engagements" v-bind:key="engagement.id">
                        <td>
                            <a v-bind:href="'/engagements/'+engagement.id">
                                <button class="btn btn-sm btn-info" title="Visualiser">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </a>
                        </td>
                        <td>{{ engagement.d_exerci }}</td>
                        <td>{{ engagement.c_dest }}</td>
                        <td>{{ engagement.nat_dep }}</td>
                        <td data-toggle="tooltip" data-placement="top" :title="engagement.l_dep">{{ engagement.format_l_dep }}</td>
                        <!-- <td>{{ engagement.m_dispo|numFormat }}</td> -->
                        <!-- <td>{{ engagement.m_toteng|numFormat }}</td> -->
                        <!-- <td>{{ engagement.m_tengvi|numFormat }}</td> -->
                        <!-- <td>{{ engagement.m_totliq|numFormat }}</td> -->
                        <!-- <td>{{ engagement.m_tordvi|numFormat }}</td> -->
                        <!-- <td>{{ engagement.m_totord|numFormat }}</td> -->
                        <!-- <td>{{ engagement.m_dotini|numFormat }}</td> -->
                        <td>{{ engagement.n_engage }}</td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ engagement.m_engage|numFormat }}</span>
                        </td>
                        <td>{{ engagement.date_depot_ac| moment("DD/MM/YYYY") }}</td>
                        <td>{{ engagement.date_paiement | moment("DD/MM/YYYY") }}</td>
                        <td class="text-center">
                            <span class="badge badge-warning">{{ engagement.m_paye|numFormat }}</span>
                        </td>
                        <td>{{ engagement.d_engage | moment("DD/MM/YYYY")}}</td>
                        <!-- <td>{{ engagement.mois_ }}</td> -->
                        <!-- <td>{{ engagement.m_tliqenga|numFormat }}</td> -->
                        <td>{{ engagement.m_non_paye|numFormat }}</td>
                        <td data-toggle="tooltip" data-placement="top" :title="engagement.l_depeng">{{ engagement.format_l_depeng }}</td>
                        <td>{{ engagement.l_nmtir }}</td>
                        <td>{{ engagement.n_mattir }}</td>
                        <td>{{ engagement.c_mattir }}</td>
                        <td>{{ engagement.l_chap }}</td>
                        <td>{{ engagement.n_devis }}</td>
                        <td>{{ engagement.desc_r_engage }}</td>
                        <!-- <td>{{ engagement.nip }}</td> -->
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>#</th>
                        <th title="Exercice">{{ 'Exercice' | truncate(20) }}</th>
                        <th title="Imputation Budgétaire">{{ 'Imputation Budgétaire' | truncate(20) }}</th>
                        <th title="Nature Dépense">{{ 'Nature Dépense' | truncate(20) }}</th>
                        <th title="Libellé Imputation Budgétaire">{{ 'Libellé Imputation Budgétaire' | truncate(20) }}</th>
                        <!-- <th>m_dispo</th> -->
                        <!-- <th>m_toteng</th> -->
                        <!-- <th>m_tengvi</th> -->
                        <!-- <th>m_totliq</th> -->
                        <!-- <th>m_tordvi</th> -->
                        <!-- <th>m_totord</th> -->
                        <!-- <th>m_dotini</th> -->
                        <th title="N° enagement">{{ 'N° enagement' | truncate(20) }}</th>
                        <th title="Montant engagé">{{ 'Montant engagé' | truncate(20) }}</th>
                        <th title="Date de dépôt Agence Comptable ANINF">{{ 'Date de dépôt Agence Comptable ANINF' | truncate(20) }}</th>
                        <th title="Date de paiements">{{ 'Date paiement' | truncate(20) }}</th>
                        <th title="Montant payé">{{ 'Montant payé' | truncate(20) }}</th>
                        <th title="Dates d’engagement">{{ 'Dates d’engagement' | truncate(20) }}</th>
                        <!-- <th>mois_</th> -->
                        <!-- <th>m_tliqenga</th> -->
                        <th title="Montants non payé">{{ 'Montants non payé' | truncate(20) }}</th>
                        <th title="Libellé de la dépense">{{ 'Libellé dépense' | truncate(20) }}</th>
                        <th title="Fournisseurs">{{ 'Fournisseurs' | truncate(20) }}</th>
                        <th title="N° matricule">{{ 'N° matricule' | truncate(20) }}</th>
                        <th title="Code matricule">{{ 'Code matricule' | truncate(20) }}</th>
                        <th title="Chapitre">{{ 'Chapitre' | truncate(20) }}</th>
                        <th title="N° devis (factures)">{{ 'N° devis (factures)' | truncate(20) }}</th>
                        <!-- <th>nip</th> -->
                        <th>Réengagement</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="javascript:" tabindex="-1" @click="fetchEngagements(pagination.prev_page_url)">Précédent</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                    <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                    <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="javascript:" @click="fetchEngagements(pagination.next_page_url)">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="modal fade" id="modal-filter">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Autres filtres</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeFilter">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Imputation</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                            v-model="filter.imputation" v-on:input="editItem('imputation')" v-on:blur="handleBlur"
                                            v-on:focus="editItem('imputation')">
                                        <ul class="suggestions" v-if="visible.imputations">
                                            <li class="none-suggestion" v-if="criteres.imputations.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.imputations" @click="selectItem('imputation', item.imputation)">{{ item.imputation }}</li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nature de la dépense</label>
                                        <select class="form-control form-control-sm" v-model="filter.nature">
                                            <option value="">Tout</option>
                                            <option v-for="(nature, index) in criteres.natures" v-bind:value="nature.nat_dep">{{ nature.nat_dep }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Libelé Imputation Budgétaire</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                            v-model="filter.lbl_imputation" v-on:input="editItem('lbl_imputation')"
                                            v-on:blur="handleBlur" v-on:focus="editItem('lbl_imputation')">
                                        <ul class="suggestions" v-if="visible.lbl_imputations">
                                            <li class="none-suggestion" v-if="criteres.lbl_imputations.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.lbl_imputations" @click="selectItem('lbl_imputation', item.lbl_imputation)">
                                                {{ item.lbl_imputation }}
                                            </li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>N° engagement</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                               v-model="filter.n_engagement" v-on:input="editItem('n_engagement')" v-on:blur="handleBlur"
                                               v-on:focus="editItem('n_engagement')">
                                        <ul class="suggestions" v-if="visible.n_engagements">
                                            <li class="none-suggestion" v-if="criteres.n_engagements.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.n_engagements" @click="selectItem('n_engagement', item.n_engagement)">
                                                {{ item.n_engagement }}
                                            </li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxPrimary1" v-model="filter.date_depot_ac.enabled">
                                            <label for="checkboxPrimary1">Date Dépot AC</label>
                                        </div>
                                        <!--<input type="text" class="form-control form-control-sm" placeholder="Enter ...">-->
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm float-right calendrier date_depot" :disabled="!filter.date_depot_ac.enabled">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxPrimary2" v-model="filter.date_paiement.enabled">
                                            <label for="checkboxPrimary2">Date Paiement</label>
                                        </div>
                                        <!--<input type="text" class="form-control form-control-sm" placeholder="Enter ...">-->
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm float-right calendrier date_paiement"
                                                   :disabled="!filter.date_paiement.enabled">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxPrimary3" v-model="filter.date_engagement.enabled">
                                            <label for="checkboxPrimary3">Dates Engagement</label>
                                        </div>
                                        <!--<input type="text" class="form-control form-control-sm" placeholder="Enter ...">-->
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm float-right calendrier date_engagement"
                                                   :disabled="!filter.date_engagement.enabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Libellé Dépense</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                               v-model="filter.lbl_depense" v-on:input="editItem('lbl_depense')" v-on:blur="handleBlur"
                                               v-on:focus="editItem('lbl_depense')">
                                        <ul class="suggestions" v-if="visible.lbl_depenses">
                                            <li class="none-suggestion" v-if="criteres.lbl_depenses.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.lbl_depenses" @click="selectItem('lbl_depense', item.lbl_depense)">
                                                {{ item.lbl_depense }}
                                            </li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Chapitre</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                               v-model="filter.chapitre" v-on:input="editItem('chapitre')" v-on:blur="handleBlur"
                                               v-on:focus="editItem('chapitre')">
                                        <ul class="suggestions" v-if="visible.chapitres">
                                            <li class="none-suggestion" v-if="criteres.chapitres.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.chapitres" @click="selectItem('chapitre', item.chapitre)">
                                                {{ item.chapitre }}
                                            </li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>N° Matricule</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                               v-model="filter.n_matricule" v-on:input="editItem('n_matricule')" v-on:blur="handleBlur"
                                               v-on:focus="editItem('n_matricule')">
                                        <ul class="suggestions" v-if="visible.n_matricules">
                                            <li class="none-suggestion" v-if="criteres.n_matricules.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.n_matricules" @click="selectItem('n_matricule', item.n_matricule)">
                                                {{ item.n_matricule }}
                                            </li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Code Matricule</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter ..."
                                               v-model="filter.c_matricule" v-on:input="editItem('c_matricule')" v-on:blur="handleBlur"
                                               v-on:focus="editItem('c_matricule')">
                                        <ul class="suggestions" v-if="visible.c_matricules">
                                            <li class="none-suggestion" v-if="criteres.c_matricules.length <= 0">Aucune suggestion</li>
                                            <li class="suggestion" v-for="item in criteres.c_matricules" @click="selectItem('c_matricule', item.c_matricule)">
                                                {{ item.c_matricule }}
                                            </li>
                                        </ul>
                                        <span>
                                            <small>Saissisez les premiers caractères</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-outline-primary float-right" @click="resetFiltre">Réinitialiser filtre</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
// import 'vue-range-component/dist/vue-range-slider.css'
// import VueRangeSlider from 'vue-range-component'

    export default {
        mounted() {
            /* BOOTSTRAP SLIDER */
            // $('.slider').bootstrapSlider()
            //Initialize Select2 Elements
            $('.select2').select2()
            // $('#range_2').ionRangeSlider()
            //Date range picker
            $('.calendrier').daterangepicker();
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
        },

        props : [],

        data(){
            return{
                engagements: [],
                providers: [],
                filter: {
                    devis: '',
                    year: {
                        start: '',
                        end: ''
                    },
                    nature: '',
                    provider: '',
                    status: '',
                    imputation: '',
                    lbl_imputation: '',
                    n_engagement: '',
                    lbl_depense: '',
                    chapitre: '',
                    n_matricule: '',
                    c_matricule: '',
                    date_depot_ac: {
                        text: '',
                        start: '',
                        end: '',
                        enabled: false,
                    },
                    date_paiement: {
                        text: '',
                        start: '',
                        end: '',
                        enabled: false,
                    },
                    date_engagement: {
                        text: '',
                        start: '',
                        end: '',
                        enabled: false,
                    },
                },
                spinner: false,
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                years: [],
                exercice: 0,
                value: [0, 100],
                criteres: {
                    natures: [],
                    lbl_imputations: [],
                    imputations: [],
                    n_engagements: [],
                    lbl_depenses: [],
                    chapitres: [],
                    n_matricules: [],
                    c_matricules: [],
                    matricule: {
                        codes: [],
                        numeros: []
                    }
                },
                visible: {
                    imputations: false,
                    lbl_imputations: false,
                    n_engagements: false,
                    lbl_depenses: false,
                    chapitres: false,
                    n_matricules: false,
                    c_matricules: false
                }

            }
        },
        components:{
            // VueRangeSlider,
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.loadYears()
                this.fetchEngagements()
                this.fetchProviders()
                this.fetchCriterias()
            }

        },

        methods: {
            fetchEngagements(page) {
                let vm = this;
                this.spinner = true;

                this.convertDate(this.filter.date_depot_ac, 'date_depot')
                this.convertDate(this.filter.date_paiement, 'date_paiement')
                this.convertDate(this.filter.date_engagement, 'date_engagement')

                let url_parameters = `api_token=${this.api_token}&start=${this.filter.year.start}&end=${this.filter.year.end}`
                    +`&devis=${this.filter.devis}&provider=${this.filter.provider}&status=${this.filter.status}`
                    +`&imputation=${this.filter.imputation}+&nature=${this.filter.nature}&lbl_imputation=${this.filter.lbl_imputation}`
                    +`&n_engagement=${this.filter.n_engagement}&lbl_depense=${this.filter.lbl_depense}&chapitre=${this.filter.chapitre}`
                    +`&n_matricule=${this.filter.n_matricule}&c_matricule=${this.filter.c_matricule}&date_depot_start=${this.filter.date_depot_ac.start}`
                    +`&date_depot_end=${this.filter.date_depot_ac.end}&date_paiement_start=${this.filter.date_paiement.start}`
                    +`&date_paiement_end=${this.filter.date_paiement.end}&date_engagement_start=${this.filter.date_engagement.start}`
                    +`&date_engagement_end=${this.filter.date_engagement.end}`

                let page_url = `/api/search?${url_parameters}`
                if(page) page_url = `${page}&${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.engagements = res.data
                        let meta = {
                            current_page: res.current_page,
                            total: res.total,
                            last_page: res.last_page,
                        }

                        let links = {
                            next: res.next_page_url,
                            prev: res.prev_page_url,
                        }
                        vm.makePagination(meta, links)
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            },
            fetchProviders(page_url) {
                let vm = this;

                page_url = page_url || `/api/providers?api_token=${this.api_token}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.providers = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinnerProviders = false
                    });
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    total: meta.total,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                }

                this.pagination = pagination;
            },
            search(){
                this.fetchEngagements();
            },
            loadYears(){
                var dt = new Date();
                let start = parseInt(dt.getFullYear())
                this.filter.exercice = parseInt(dt.getFullYear())
                this.exercice = parseInt(dt.getFullYear())
                for(var i=0; i <= parseInt(dt.getFullYear()); i++){
                    this.years[i] = start
                    start --
                    if(start < 2010) break
                }
            },
            selectStart(){
                this.filter.year.end = this.filter.year.start
            },
            selectEnd(){
                if(parseInt(this.filter.year.end) < parseInt(this.filter.year.start))
                    this.filter.year.end = this.filter.year.start
            },
            openFilter(){
                $('#modal-filter').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeFilter(){

            },
            fetchCriterias(){
                let url_parameters = `api_token=${this.api_token}&imputation=${this.filter.imputation}`
                    +`&lbl_imputation=${this.filter.lbl_imputation}&n_engagement=${this.filter.n_engagement}`
                    +`&lbl_depense=${this.filter.lbl_depense}&chapitre=${this.filter.chapitre}&n_matricule=${this.filter.n_matricule}`
                    +`&c_matricule=${this.filter.c_matricule}`

                let page_url = `/api/engagements/search/criteres?${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.criteres = res
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                    });
            },
            selectItem(critere, valeur){
                switch (critere){
                    case 'imputation':
                        this.filter.imputation = valeur
                        this.visible.imputations = false
                        break
                    case 'lbl_imputation':
                        this.filter.lbl_imputation = valeur
                        this.visible.lbl_imputations = false
                        break
                    case 'n_engagement':
                        this.filter.n_engagement = valeur
                        this.visible.n_engagements = false
                        break
                    case 'lbl_depense':
                        this.filter.lbl_depense = valeur
                        this.visible.lbl_depenses = false
                        break
                    case 'chapitre':
                        this.filter.chapitre = valeur
                        this.visible.chapitres = false
                        break
                    case 'n_matricule':
                        this.filter.n_matricule = valeur
                        this.visible.n_matricules = false
                        break
                    case 'c_matricule':
                        this.filter.c_matricule = valeur
                        this.visible.c_matricules = false
                        break
                }

                this.fetchCriterias()
            },
            editItem(critere){
                let vm = this
                setTimeout(function () {
                    switch (critere){
                        case 'imputation':
                            vm.visible.imputations = true
                            break
                        case 'lbl_imputation':
                            vm.visible.lbl_imputations = true
                            break
                        case 'n_engagement':
                            vm.visible.n_engagements = true
                            break
                        case 'lbl_depense':
                            vm.visible.lbl_depenses = true
                            break
                        case 'chapitre':
                            vm.visible.chapitres = true
                            break
                        case 'n_matricule':
                            vm.visible.n_matricules = true
                            break
                        case 'c_matricule':
                            vm.visible.c_matricules = true
                            break
                    }
                }, 200)

                this.fetchCriterias()
            },
            handleBlur(){
                let vm = this
                setTimeout(function () {
                    vm.visible.imputations = false
                    vm.visible.lbl_imputations = false
                    vm.visible.n_engagements = false
                    vm.visible.lbl_depenses = false
                    vm.visible.chapitres = false
                    vm.visible.n_matricules = false
                    vm.visible.c_matricules = false
                }, 200)
            },
            resetFiltre(){
                this.filter = {
                    devis: '',
                    year: {
                        start: '',
                        end: ''
                    },
                    nature: '',
                    provider: '',
                    status: '',
                    imputation: '',
                    lbl_imputation: '',
                    n_engagement: '',
                    lbl_depense: '',
                    chapitre: '',
                    n_matricule: '',
                    c_matricule: '',
                    date_depot_ac: {
                        text: '',
                        start: '',
                        end: '',
                        enabled: false,
                    },
                    date_paiement: {
                        text: '',
                        start: '',
                        end: '',
                        enabled: false,
                    },
                    date_engagement: {
                        text: '',
                        start: '',
                        end: '',
                        enabled: false,
                    },
                }
            },
            convertDate(date, input){
                this.$forceUpdate();
                switch (input){
                    case 'date_depot':
                        date.text = $(".date_depot").val()
                        break
                    case 'date_paiement':
                        date.text = $(".date_paiement").val()
                        break
                    case 'date_engagement':
                        date.text = $(".date_engagement").val()
                        break
                }
                if(date.text != '' && date.enabled == true){
                    let a = date.text.split(" - ")
                    date.start = this.transformDate(a[0])
                    date.end = this.transformDate(a[1])
                }else{
                    date.start = ''
                    date.end = ''
                }
            },
            transformDate(date){
                let a = date.split("/")
                return a[2]+"-"+a[0]+"-"+a[1]
            }
        }

    }
</script>
