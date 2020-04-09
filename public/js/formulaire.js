
class Formulaire {

    constructor(form, formData) {

        this.formulaire = form;
        this.formData = formData;
    }

    // Ajoput message
    verifForm() {
        try {

            let response = fetch(this.formulaire.action,
            {
                method: 'post',
                body: this.formData
            })

            if (response.ok === true)
            {
                console.log('réponse OK');
                let responseData = response;
                this.validMessage();
            } 
            else // réponse n'est pas 200
            {
                console.log('réponse HS');
                this.errorMessage();
            }

        }
        catch (e) {
            alert(e);
        }
    }

    validMessage() {
        message.style.display = 'block';
        message.classList.add('valid');
        message.innerHTML = 'Validé !';
        setTimeout(()=> this.clearMessage(), 3000); // 3s
    }

    errorMessage() {
        message.style.display = 'block';
        message.classList.add('error');
        message.innerHTML = 'ERREUR : un problème est survenue !';
        setTimeout(()=> this.clearMessage(), 3000); // 3s
    }

    clearMessage () {
        message.classList.remove('valid');
        message.classList.remove('error');
        message.style.display = 'none';
    }
}