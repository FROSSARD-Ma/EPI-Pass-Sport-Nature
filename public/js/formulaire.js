
class Formulaire {

    constructor(form, formData) {

        this.formulaire = form;
        this.formData = formData;
    }

    // Ajoput message
    verifForm() {

        fetch(this.formulaire.action,
        {
            method: 'post',
            body: this.formData
        })
        .then(function(response)
        {
            if (response.ok)
            {
                let nxMsg = new Message ('Enregistrement validé !');
                nxMsg.validMessage();
            } 
            else
            {
                let nxMsg = new Message ('ERREUR : un problème est survenue !');
                nxMsg.errorMessage();
            }    

        }, function(error)
        {
            let nxMsg = new Message (error);
            nxMsg.errorMessage();
        })
    }
}