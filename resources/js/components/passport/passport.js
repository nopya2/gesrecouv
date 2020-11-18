Vue.component(
    'passport-clients',
    require('./Clients.vue').default
);

Vue.component(
    'passport-authorized-client',
    require('./AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./PersonalAccessTokens.vue').default
);
