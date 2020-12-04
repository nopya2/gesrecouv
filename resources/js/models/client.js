class Client{
    constructor(id, utilisateur_id, raison_sociale, nif, bp, adresse, pays, ville, tel, responsable, 
                tel_responsable, email, type, created_at, updated_at, secteur_id = "") {
        this.id = id;
        this.utilisateur_id = utilisateur_id;
        this.raison_sociale = raison_sociale;
        this.nif = nif;
        this.bp = bp;
        this.adresse = adresse;
        this.pays = pays;
        this.ville = ville;
        this.tel = tel;
        this.responsable = responsable;
        this.tel_responsable = tel_responsable;
        this.email = email;
        this.type = type;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.secteur_id = secteur_id
     }
}

export default Client
