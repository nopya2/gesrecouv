<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-flag text-danger"></i>
                            {{ client.raison_sociale }}
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a
                                    type="button" class="btn btn-sm btn-primary"
                                    :href="'/clients/'+previous" v-if="previous > 0">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <a
                                    type="button" class="btn btn-sm btn-primary"
                                    :href="'/clients/'+next" v-if="next > 0">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- <ul class="nav nav-pills ml-auto">
                            <li class="nav-item ml-2">
                                <a class="btn nav-link text-primary" :href="'/clients/'+previous" v-if="previous > 0">
                                    <i class="fas fa-arrow-circle-left text-lg"></i>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a class="btn nav-link text-primary" :href="'/clients/'+next" v-if="next > 0">
                                    <i class="fas fa-arrow-circle-right text-lg"></i>
                                </a>
                            </li>
                        </ul> -->
                    </div>
                    <div class="card-body">
                        <p class="text-muted" style="font-size: 1.75rem">Somme due : {{ client.m_not_paid|numFormat }} Fcfa</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-warning card-outline orange">
                                    <div class="card-body text-muted">
                                        En retard<br>
                                        <strong class="text-lg">{{ client.m_not_paid_late|numFormat }} Fcfa</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-primary card-outline bleu">
                                    <div class="card-body text-muted">
                                        En attente<br>
                                        <strong class="text-lg">{{ client.m_not_paid_waiting|numFormat }} Fcfa</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-success card-outline vert">
                                    <div class="card-body text-muted">
                                        Payé<br>
                                        <strong class="text-lg">{{ client.m_paid|numFormat }} Fcfa</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Client
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-warning btn-sm" title="Modifier">
                                <a :href="'/clients/'+client.id+'/edit'" class="text-light">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </button>
                            <button class="btn btn-danger btn-sm" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>
                                <strong>Nom:</strong> {{ client.raison_sociale}}
                            </li>
                            <li v-if="client.secteur">
                                <strong>Secteur activité:</strong> {{ client.secteur.name }}
                            </li>
                            <li>
                                <strong>Contact:</strong> {{ client.responsable || "N/A"}}
                                <ul>
                                    <li>
                                        <strong>Email: </strong> {{ client.email || "N/A" }}
                                    </li>
                                    <li>
                                        <strong>Tél: </strong> {{ client.tel_responsable || "N/A" }}
                                    </li>
                                    <li>
                                        <strong>Adresse: </strong> {{ client.adresse || "N/A" }}
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Activité
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-info" title="historique des activités">
                                <i class="fas fa-history"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <h3 class="text-info">Prévénance</h3>
                                Prochaine échéance: 
                                <span v-if="nb_days_next_echeance > 0">{{nb_days_next_echeance}} jours</span>
                                <span v-if="nb_days_next_echeance <= 0">Aucune échéance</span>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-orange">Relance</h3>
                                <span v-if="nb_days_first_late_facture > 0">En retard depuis {{nb_days_first_late_facture}} jours</span>
                                <span v-if="nb_days_first_late_facture <= 0">Aucun retard</span>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-success">Règlement</h3>
                                Dernier règlement:
                                <span v-if="nb_days_last_paiement > 0">{{nb_days_last_paiement}} jours</span>
                                <span v-if="nb_days_last_paiement <= 0">Aucun paiement</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- <h3 class="text-info">Prévénance</h3>
                                Prochaine échéance:  -->
                            </div>
                            <div class="col-md-4">
                                Relancé: <span class="text-info">3 fois</span><br>
                                Dernière relance: le <span class="text-info">3 fois</span>
                            </div>
                            <div class="col-md-4">
                                <!-- <h3 class="text-success">Règlement</h3>
                                Dernier règlement  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <ListFactures :client_id="client_id"></ListFactures>
            </div>
        </div>
    </div>
</template>

<script>
    import Client from './../../models/client'
    import ListFactures from './ListFactures'

    export default {
        components: {
            ListFactures
        },

        props : ['client_id', 'previous', 'next', 'nb_days_next_echeance', 'nb_days_last_paiement', 'nb_days_first_late_facture'],

        data(){
            return{
                client: new Client(),
            }
        },
        created(){
            this.fetchClient()
        },

        methods: {
            fetchClient(){
                let vm = this;

                axios.get(`/api/clients/${this.client_id}`)
                    .then(res => {
                        vm.client = res.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement du client!')
                    });
            }
        }

    }
</script>

<style scoped>
    .orange .card-body{
        background: #ffecb3;
    }
    .bleu .card-body{
        background: #b3e5fc;
    }
    .vert .card-body{
        background: #c8e6c9;
    }
    /* .orange {
        border: none;
        border-top: 8px solid #ffb300;
        color: white;
        box-shadow: 2px 2px 2px gray ;
    }
    .bleu {
        border: none;
        color: white;
        background: #039be5;
        box-shadow: 2px 2px 2px gray;
    }
    .vert {
        border: none;
        color: white;
        
    } */
</style>
