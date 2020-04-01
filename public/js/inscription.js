class Inscription {

  constructor(formElt, statutGp, groupeElt, userElt, nameLabel, btnForm) {

    // DOM selectors
    this.formulaire   = formElt;
    this.statutGp     = statutGp;
    this.groupeElt    = groupeElt;
    this.userElt      = userElt;
    this.nameLabel    = nameLabel;
  }

  editForm()
  {
    if (this.statutGp =='Particulier')
    {
        this.groupeElt.style.display = 'none';
        this.userElt.style.display = 'block';
    }
    else if (this.statutGp !='')
    {
        this.nameLabel.innerHTML += " du responsable";
        this.groupeElt.style.display = 'block';
        this.userElt.style.display = 'block';
    }
    else
    {
        this.groupeElt.style.display = 'none';
        this.userElt.style.display = 'none';
    }

  }
}