class Facture{
    constructor(id, utilisateur_id, parent_id, client_id, type_id, statut, num_facture, montant, num_dossier, date_creation, date_depot, date_echeance, date_paiement, commentaire, created_at, updated_at, m_paid, m_not_paid) {
        this.id = id;
        this.utilisateur_id = utilisateur_id;
        this.parent_id = parent_id;
        this.client_id = client_id;
        this.type_id = type_id;
        this.statut = statut;
        this.num_facture = num_facture;
        this.montant = montant;
        this.num_dossier = num_dossier;
        this.date_creation = date_creation;
        this.date_depot = date_depot;
        this.date_echeance = date_echeance;
        this.date_paiement = date_paiement;
        this.commentaire = commentaire;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.m_paid = m_paid;
        this.m_not_paid = m_not_paid;
     }
}

export default Facture
