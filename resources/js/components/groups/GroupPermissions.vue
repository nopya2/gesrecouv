<template>
    <div class="card-block table-border-style">
        <div class="callout callout-light" v-for="module in modules" :key="module.id">
          <h5>{{ module.name }}</h5>

          <div class="row">
              <div class="col-md-3" v-for="permission in module.permissions" :key="permission.id">
                  <div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                          <input type="checkbox" :checked="hasPermission(permission.id)" :id="'checkboxPrimary1'+permission.id" @change="changePermission(group.id, permission.id, $event)">
                          <label :for="'checkboxPrimary1'+permission.id">{{ permission.name }}</label>
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
        },

        props: ['group_id'],

        data(){
            return{
                group: {
                    permissions: []
                },
                api_token: '',
                modules: [],
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchGroup()
                this.fetchModules()
            }

        },

        methods: {
            fetchGroup() {

                let page_url = `/api/groups/${this.group_id}?api_token=${this.api_token}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.group = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur sélection du groupe!.')
                    });
            },
            fetchModules() {
                let page_url = `/api/modules?api_token=${this.api_token}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.modules = res.data
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            hasPermission(permissionId){
                let index = this.group.permissions.findIndex(x => x.id === permissionId);
                if(index !== -1) {
                    return true;
                }
                else {
                    return false;
                }
            },
            changePermission(group, permission, $event){
                let action = "";
                //On ajoute ou on supprime la permission
                if($event.target.checked == true) action = "add";
                if($event.target.checked == false) action = "delete";

                fetch('/api/groups/'+group+'/permission-change/'+permission+'?action='+action, {
                    method: 'post'
                })
                    .then(res => res.json())
                    .then(res => {
                        this.group = res.data
                        // console.log(data)
                    })
                    .catch(error => {
                        toastr.error('Une erreur s\'est produite lors de la requete!')
                    });
            },

        }

    }
</script>
