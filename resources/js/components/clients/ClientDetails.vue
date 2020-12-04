<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
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
                            <div class="col-md-2">
                                <div class="alert border-warning text-orange" role="alert">
                                    <h5><strong>En retard</strong></h5>
                                    <h4>
                                        {{ client.m_not_paid_late|numFormat }} Fcfa
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="alert border-primary text-primary" role="alert">
                                    <h5><strong>A venir</strong></h5>
                                    <h4>
                                        {{ client.m_not_paid_waiting|numFormat }} Fcfa
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="alert border-success text-success" role="alert">
                                    <h5><strong>Payé</strong></h5>
                                    <h4>
                                        {{ client.m_paid|numFormat }} Fcfa
                                    </h4>
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
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-orange">Relance</h3>
                                En retard
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-success">Règlement</h3>
                                Dernier règlement 
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

        props : ['client_id', 'previous', 'next'],

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
</style>
