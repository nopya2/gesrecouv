import Facture from './facture'

class Paiement{
    constructor(id, user_id, facture_id, facture = Facture, montant = 0, mode_paiement, date_paiement, commentaire, created_at, updated_at) {
        this.id = id;
        this.user_id = user_id;
        this.facture_id = facture_id;
        this.montant = montant,
        this.mode_paiement = mode_paiement;
        this.date_paiement = date_paiement;
        this.commentaire = commentaire;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.facture = facture
     }
}

export default Paiement
