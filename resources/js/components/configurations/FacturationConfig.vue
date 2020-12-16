<template>
<div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Durée de l'échéance</label>
                <input type="number" class="form-control" id="duree_echeance" placeholder="" v-model="config.duree_echeance">
            </div>
        </div>
        <div class="col-md-6">
            <br>
            <i class="italic text-muted">La durée en jours par défaut définie pour l'échéance d'une facture après le dépot chez le client</i>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Notifications</label>
                <input type="number" class="form-control" id="duree_min_echeance" placeholder="" v-model="config.duree_echeance_max">
            </div>
        </div>
        <div class="col-md-6">
            <br>
            <i class="italic text-muted">Nombre de jours pour le décléchement d'une notification avant la date d'échéance</i>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Durée maximale</label>
                <input type="number" class="form-control" id="duree_max_echeance" placeholder="" v-model="config.duree_echeance_min">
            </div>
        </div>
        <div class="col-md-6">
            <br>
            <i class="italic text-muted">Nombre de jours maximum avant que le facture ne soit convertie en facture litigieuse</i>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-success btn-sm" @click="save">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
        </div>
    </div>
</div>
</template>

<script>
    import Configuration from './../../services/configuration'

    export default {
        mounted() {

        },

        props : ['configurations'],

        data(){
            return{
                config: {}
            }
        },

        created(){
            this.config = Configuration.getCNF()
        },

        methods: {
            save(){
                let vm = this;

                axios.put(`/api/configurations`, vm.config)
                    .then(res => {
                        toastr.warning('Modifications enregistrées!')
                    })
                    .catch(error => {
                        toastr.error('Modifications non enregistrées!')
                    });

            }
        }

    }
</script>
