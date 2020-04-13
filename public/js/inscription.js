class Inscription {

    constructor(formElt, statut, groupeElt, gpH3, gpName, gpMail, userElt, nameLabel, userName, userFirstname, userMail, userPass, inscBtn, nextBtn, prevBtn) {

        // DOM selectors
        this.formulaire     = formElt;
        this.gpStatut       = statut;

        this.groupeElt      = groupeElt;
        this.gpH3           = gpH3;
        this.h3             = this.gpStatut.value;
        this.gpName         = gpName;
        this.gpMail         = gpMail;

        this.userElt        = userElt;
        this.nameLabel      = nameLabel;
        this.userName       = userName;
        this.userFirstname  = userFirstname;
        this.userMail       = userMail;
        this.userPass       = userPass;

        this.inscBtn         = inscBtn;
        this.nextBtn        = nextBtn;
        this.prevBtn        = prevBtn;
    }

    
    refreshForm()
    {

        if (this.gpStatut =='Particulier')
        {
            this.nameLabel.innerHTML = "Nom";
            this.userSection();
        }
        else if (this.gpStatut !='')
        {
            this.nameLabel.innerHTML = "Nom du responsable";
            this.groupeSection();
        }
        else
        {
             this.statutSection();
        }
    }

    statutSection()
    {
        this.prevBtn.style.display = 'none';
        this.nextBtn.style.display = 'none';
        this.inscBtn.style.display = 'none';
    }

    groupeSection()
    {
        
        this.groupeElt.style.display = 'block';
        this.gpH3.innerHTML = this.h3;
        this.userElt.style.display = 'none';

        /*inscBtn*/
        this.prevBtn.style.display = 'none';
        this.nextBtn.style.display = 'block';
        this.inscBtn.style.display = 'none';

        this.nextBtn.addEventListener('click', () =>
        {
            this.prevBtn.style.display = 'block';
            this.userSection();
        });
    }

    userSection()
    {
        this.groupeElt.style.display = 'none';
        this.userElt.style.display = 'block';
        /*inscBtn*/
        this.nextBtn.style.display = 'none';
        
        this.inscBtn.style.display = 'block';

        this.prevBtn.addEventListener('click', () =>
        {
            this.groupeSection();
        });
    }
}