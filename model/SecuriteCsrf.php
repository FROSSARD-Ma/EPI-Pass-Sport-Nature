<?php
namespace Epi_Model;

class SecuriteCsrf
{
	private $_nameForm; // Nom du formulaire
	private $_tempsValidForm = 600; // Temps validation Formulaire (10 min * 60s)en timestamp

	public function __construct($form = null)
	{
		$this->_nameForm = $form;
	}

    // génère, sauvegarde et retourne un token
    public function getToken()
	{
		$token = bin2hex(openssl_random_pseudo_bytes(6)); //On génére un token unique de 6 x 2 caractères.
		$_SESSION[$this->_nameForm.'_token'] = $token;
		$_SESSION[$this->_nameForm.'_token_time'] = time();
		return $token;
	}

    public function verifToken($referer)
    {
    	// Token présent dans la session et dans le formulaire ?
		if(isset($_SESSION[$this->_nameForm.'_token']) && isset($_SESSION[$this->_nameForm.'_token_time']) && isset($_POST['token']))
		{
			// Si token session correspond au tokenformulaire
			if($_SESSION[$this->_nameForm.'_token'] == $_POST['token'])
			{
				// Temps du token valide ?
				if($_SESSION[$this->_nameForm.'_token_time'] >= (time() - $this->_tempsValidForm))
				{
					// Si la requete vient du formulaire
					if($_SERVER['HTTP_REFERER'] == $referer)
					{
						return true;
					}
				}
			}
		}
		return false;
    }


} 